<?php

namespace app\models;

use app\models\Banco;
use PDO;
use stdClass;

class Usuario
{
    public $banco;

    public function __construct()
    {
        $this->banco = new Banco;
    }

    public function pegarTodos()
    {
        try {
            $this->banco->conectar();

            $sql = "SELECT * FROM usuario";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function exsiteUsuario($dados)
    {
        try {
            $this->banco->conectar();

            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? $dados["senha"] : NULL;

            $existeEmail = $this->existeEmail($dados);

            if (password_verify($senha, $existeEmail["senha"])) {
                $senha = $existeEmail["senha"];
            }

            $sql = "SELECT nome, email FROM usuario WHERE email = :email AND senha = :senha";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $dados;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function existeEmail($dados)
    {
        try {
            $this->banco->conectar();

            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $id = isset($dados["id"]) ? $dados["id"] : 0;

            $sql = "SELECT email, senha FROM usuario WHERE email = :email AND id <> :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $dado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (count($dado) > 0) {
                return $dado;
            }

            return FALSE;
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
            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? password_hash($dados["senha"], PASSWORD_DEFAULT) : NULL;
            $img = isset($dados["img"]) ? $dados["img"] : NULL;

            $sql = "INSERT INTO usuario (nome,email,senha,img) VALUES (:nome,:email,:senha,:img)";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);
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

            $sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha , img = :img WHERE id = :id";
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

            $sql = "DELETE FROM usuario WHERE id = :id";
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