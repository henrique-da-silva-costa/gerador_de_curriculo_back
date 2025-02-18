<?php

namespace app\models;

use app\controllers\Tabelas;
use app\models\Banco;
use PDO;
use stdClass;

class Usuario
{
    public $banco;
    public $tabela;

    public function __construct()
    {
        $this->banco = new Banco;
        $this->tabela = Tabelas::USUARIO;
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

    public function exsiteUsuario($dados)
    {
        try {
            $this->banco->conectar();

            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? $dados["senha"] : NULL;

            $existeEmail = $this->existeEmail($dados);

            if (!$existeEmail) {
                return FALSE;
            }

            if (password_verify($senha, $existeEmail["senha"])) {
                $senha = $existeEmail["senha"];
            }

            $sql = "SELECT nome, email, id FROM {$this->tabela} WHERE email = :email AND senha = :senha";
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

            $sql = "SELECT email, senha FROM {$this->tabela} WHERE email = :email AND id <> :id";
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

    public function existeSenha($dados)
    {
        try {
            $this->banco->conectar();

            $senha = isset($dados["senha"]) ? $dados["senha"] : NULL;

            $existeEmail = $this->existeEmail($dados);

            if (password_verify($senha, $existeEmail["senha"])) {
                $senha = $existeEmail["senha"];
            }

            $sql = "SELECT senha FROM {$this->tabela} WHERE senha = :senha";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
            $stmt->execute();
            $dado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (count($dado) > 0) {
                return TRUE;
            }

            return FALSE;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function recuperarSenha($dados)
    {
        try {
            $this->banco->conectar();
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $novaSenha = isset($dados["novaSenha"]) ? password_hash($dados["novaSenha"], PASSWORD_DEFAULT) : NULL;

            $sql = "UPDATE {$this->tabela} SET senha = :senha WHERE email = :email";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $novaSenha, PDO::PARAM_STR);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
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
            $img = isset($dados["img"]) ? "http://localhost:1999/uploads/" . $dados["img"] : NULL;

            $sql = "INSERT INTO {$this->tabela} (nome,email,senha,img) VALUES (:nome,:email,:senha,:img)";
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
