<?php

namespace app\models;

use PDO;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT,DELETE');
header("Access-Control-Allow-Headers: Origin,Accept,AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");

class Banco
{
    public $host;
    public $dbname;
    public $usuario;
    public $senha;
    public $conexao;

    public function __construct()
    {
        $this->host = "localhost";
        $this->dbname = "usuario";
        $this->usuario = "root";
        $this->senha = "";
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
