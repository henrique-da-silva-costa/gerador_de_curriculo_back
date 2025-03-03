<?php

namespace app\models;

use app\controllers\Tabelas;
use app\models\Banco;
use PDO;
use stdClass;

class Curriculo
{
    public $banco;
    public $tabela;

    public function __construct()
    {
        $this->banco = new Banco;
        $this->tabela = Tabelas::CURRICULO;
    }

    public function pegarPorCurriculoPorUsuarioId($usuario_id)
    {
        try {
            $this->banco->conectar();
            $porPagina = 4;

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($paginaAtual - 1) * $porPagina;

            $stmt = $this->banco->conexao->prepare("SELECT * FROM {$this->tabela} WHERE usuario_id = :usuario_id ORDER BY id DESC LIMIT :offset, :porPagina");
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmtTotal = $this->banco->conexao->query("SELECT COUNT(*) as total FROM {$this->tabela} WHERE usuario_id = $usuario_id");
            $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

            $totalPaginas = ceil($total / $porPagina);

            return [
                'dados' => $dados,
                'paginaAtual' => $paginaAtual,
                'totalPaginas' => $totalPaginas
            ];
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarPorId($id)
    {
        try {
            $this->banco->conectar();

            $sql = "SELECT * FROM {$this->tabela} WHERE id = $id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $dados;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function pegarTodos()
    {
        try {
            $this->banco->conectar();

            $sql = "SELECT * FROM {$this->tabela}";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function cadastrar($dados)
    {
        try {
            $this->banco->conectar();

            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;
            $resposta->id = NULL;

            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $sexo = isset($dados["sexo"]) ? $dados["sexo"] : NULL;
            $estado_civil = isset($dados["estado_civil"]) ? $dados["estado_civil"] : NULL;
            $telefone = isset($dados["telefone"]) ? $dados["telefone"] : NULL;
            $data_nascimento = isset($dados["data_nascimento"]) ? $dados["data_nascimento"] : NULL;
            $img = isset($dados["img"]) ? $dados["img"] : NULL;
            $descricao = isset($dados["descricao"]) ? $dados["descricao"] : NULL;
            $usuario_id = isset($dados["usuario_id"]) ? $dados["usuario_id"] : NULL;

            $sql = "INSERT INTO {$this->tabela} (
            nome,
            sexo,
            estado_civil,
            telefone,
            data_nascimento,
            img,
            descricao,
            usuario_id) VALUES (
            :nome,
            :sexo,
            :estado_civil,
            :telefone,
            :data_nascimento,
            :img,
            :descricao,
            :usuario_id
            )";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":sexo", $sexo, PDO::PARAM_STR);
            $stmt->bindParam(":estado_civil", $estado_civil, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
            $stmt->bindParam(":data_nascimento", $data_nascimento, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            $resposta->id = $this->banco->conexao->lastInsertId();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();
            $resposta->id = NULL;

            return $resposta;
        }
    }

    public function editar($dados)
    {
        try {
            $this->banco->conectar();
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $sexo = isset($dados["sexo"]) ? $dados["sexo"] : NULL;
            $estado_civil = isset($dados["estado_civil"]) ? $dados["estado_civil"] : NULL;
            $telefone = isset($dados["telefone"]) ? $dados["telefone"] : NULL;
            $data_nascimento = isset($dados["data_nascimento"]) ? $dados["data_nascimento"] : NULL;
            $img = isset($dados["img"]) ? $dados["img"] : NULL;
            $descricao = isset($dados["descricao"]) ? $dados["descricao"] : NULL;
            $usuario_id = isset($dados["usuario_id"]) ? $dados["usuario_id"] : NULL;

            if (!is_numeric($id)) {
                return;
            }

            $sql = "UPDATE {$this->tabela} SET
            nome = :nome,
            sexo = :sexo,
            estado_civil = :estado_civil,
            telefone = :telefone,
            data_nascimento = :data_nascimento,
            img = :img,
            descricao = :descricao,
            usuario_id = :usuario_id WHERE id = :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":sexo", $sexo, PDO::PARAM_STR);
            $stmt->bindParam(":estado_civil", $estado_civil, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
            $stmt->bindParam(":data_nascimento", $data_nascimento, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }

    public function excluir($dados)
    {
        try {
            $this->banco->conectar();
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $id = isset($dados["id"]) ? $dados["id"] : NULL;

            if (!is_numeric($id)) {
                return;
            }

            $sql = "DELETE FROM {$this->tabela} WHERE id = :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }
}
