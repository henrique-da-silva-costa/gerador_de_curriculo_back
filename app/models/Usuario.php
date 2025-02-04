<?php

namespace app\models;

use app\models\Banco;

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
            $dados = $stmt->fetchAll();

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
