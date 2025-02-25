<?php

namespace app\models;

use PDO;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin,Cache-Control, Pragma , Accept, AccountKey, X-Requested-With, Content-Type, Client-Security-Token, Host, Date, Cookie, Cookie2");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

class Banco
{
    private $host;
    private $dbname;
    private $usuario;
    private $senha;
    public $conexao;

    public function __construct()
    {
        $this->host = "localhost";
        $this->dbname = "usuario";
        $this->usuario = "root";
        $this->senha = "";

        // $this->host = "localhost";
        // $this->dbname = "u490439394_curriculo";
        // $this->usuario = "u490439394_curriculo";
        // $this->senha = "Henrique1999@";
    }

    public function conectar()
    {
        try {
            $this->conexao = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->usuario, $this->senha);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }
}
