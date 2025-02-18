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

    public function pegarPorUsuarioId($usuario_id)
    {
        try {
            $this->banco->conectar();
            $porPagina = 4;

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($paginaAtual - 1) * $porPagina;

            $stmt = $this->banco->conexao->prepare("SELECT * FROM {$this->tabela} WHERE usuario_id = :usuario_id LIMIT :offset, :porPagina");
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

            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $descricao = isset($dados["descricao"]) ? $dados["descricao"] : NULL;
            $estado_civil = isset($dados["estado_civil"]) ? $dados["estado_civil"] : NULL;
            $telefone = isset($dados["telefone"]) ? $dados["telefone"] : NULL;
            $data_nascimento = isset($dados["data_nascimento"]) ? $dados["data_nascimento"] : NULL;
            $empresa = isset($dados["empresa"]) ? $dados["empresa"] : NULL;
            $cargo = isset($dados["cargo"]) ? $dados["cargo"] : NULL;
            $responsabilidades = isset($dados["responsabilidades"]) ? $dados["responsabilidades"] : NULL;
            $habilidades = isset($dados["habilidades"]) ? $dados["habilidades"] : NULL;
            $data_inicio = isset($dados["data_inicio"]) ? $dados["data_inicio"] : NULL;
            $data_fim = isset($dados["data_fim"]) ? $dados["data_fim"] : NULL;
            $usuario_id = isset($dados["usuario_id"]) ? $dados["usuario_id"] : NULL;
            $img = isset($dados["img"]) ? "http://localhost:1999/" . $dados["img"] : NULL;

            $sql = "INSERT INTO {$this->tabela} (
            nome,
            descricao,
            estado_civil,
            telefone,
            data_nascimento,
            empresa,
            cargo,
            responsabilidades,
            habilidades,
            data_inicio,
            data_fim,
            img,
            usuario_id) VALUES (
            :nome,
            :descricao,
            :estado_civil,
            :telefone,
            :data_nascimento,
            :empresa,
            :cargo,
            :responsabilidades,
            :habilidades,
            :data_inicio,
            :data_fim,
            :img,
            :usuario_id
            )";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->bindParam(":estado_civil", $estado_civil, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
            $stmt->bindParam(":data_nascimento", $data_nascimento, PDO::PARAM_STR);
            $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
            $stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
            $stmt->bindParam(":responsabilidades", $responsabilidades, PDO::PARAM_STR);
            $stmt->bindParam(":habilidades", $habilidades, PDO::PARAM_STR);
            $stmt->bindParam(":data_inicio", $data_inicio, PDO::PARAM_STR);
            $stmt->bindParam(":data_fim", $data_fim, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

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
            $descricao = isset($dados["descricao"]) ? $dados["descricao"] : NULL;
            $estado_civil = isset($dados["estado_civil"]) ? $dados["estado_civil"] : NULL;
            $telefone = isset($dados["telefone"]) ? $dados["telefone"] : NULL;
            $data_nascimento = isset($dados["data_nascimento"]) ? $dados["data_nascimento"] : NULL;
            $empresa = isset($dados["empresa"]) ? $dados["empresa"] : NULL;
            $cargo = isset($dados["cargo"]) ? $dados["cargo"] : NULL;
            $responsabilidades = isset($dados["responsabilidades"]) ? $dados["responsabilidades"] : NULL;
            $habilidades = isset($dados["habilidades"]) ? $dados["habilidades"] : NULL;
            $data_inicio = isset($dados["data_inicio"]) ? $dados["data_inicio"] : NULL;
            $data_fim = isset($dados["data_fim"]) ? $dados["data_fim"] : NULL;
            $usuario_id = isset($dados["usuario_id"]) ? $dados["usuario_id"] : NULL;
            $img = isset($dados["img"]) ? $dados["img"] : NULL;

            if (!is_numeric($id)) {
                return;
            }

            $sql = "UPDATE {$this->tabela} SET
            nome = :nome,
            descricao = :descricao,
            estado_civil = :estado_civil,
            telefone = :telefone,
            data_nascimento = :data_nascimento,
            empresa = :empresa,
            cargo = :cargo,
            responsabilidades = :responsabilidades,
            habilidades = :habilidades,
            data_inicio = :data_inicio,
            data_fim = :data_fim,
            img = :img,
            usuario_id = :usuario_id WHERE id = :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->bindParam(":estado_civil", $estado_civil, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
            $stmt->bindParam(":data_nascimento", $data_nascimento, PDO::PARAM_STR);
            $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
            $stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
            $stmt->bindParam(":responsabilidades", $responsabilidades, PDO::PARAM_STR);
            $stmt->bindParam(":habilidades", $habilidades, PDO::PARAM_STR);
            $stmt->bindParam(":data_inicio", $data_inicio, PDO::PARAM_STR);
            $stmt->bindParam(":data_fim", $data_fim, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);
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
