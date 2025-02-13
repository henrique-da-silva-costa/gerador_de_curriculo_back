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

    public function pegarPorId($dados)
    {
        try {
            $this->banco->conectar();

            $id = isset($dados["id"]) ? $dados["id"] : NULL;

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

            $nome = isset($_POST["nome"]) ? $_POST["nome"] : NULL;
            $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : NULL;
            $estado_civil = isset($_POST["estado_civil"]) ? $_POST["estado_civil"] : NULL;
            $telefone = isset($_POST["telefone"]) ? $_POST["telefone"] : NULL;
            $data_nascimento = isset($_POST["data_nascimento"]) ? $_POST["data_nascimento"] : NULL;
            $empresa = isset($_POST["empresa"]) ? $_POST["empresa"] : NULL;
            $cargo = isset($_POST["cargo"]) ? $_POST["cargo"] : NULL;
            $responsabilidades = isset($_POST["responsabilidades"]) ? $_POST["responsabilidades"] : NULL;
            $habilidades = isset($_POST["habilidades"]) ? $_POST["habilidades"] : NULL;
            $data_inicio = isset($_POST["data_inicio"]) ? $_POST["data_inicio"] : NULL;
            $data_fim = isset($_POST["data_fim"]) ? $_POST["data_fim"] : NULL;
            $usuario_id = isset($_POST["usuario_id"]) ? $_POST["usuario_id"] : NULL;

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
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            $dados = $stmt->fetchAll();

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
            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? password_hash($dados["senha"], PASSWORD_DEFAULT) : NULL;
            $img = isset($dados["img"]) ? $dados["img"] : NULL;

            if (!is_numeric($id)) {
                return;
            }

            $sql = "UPDATE {$this->tabela} SET nome = :nome, email = :email, senha = :senha , img = :img WHERE id = :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);
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
