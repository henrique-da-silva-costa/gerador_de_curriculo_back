<?php

namespace app\controllers;

use Dotenv\Dotenv;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class AutenticacaoJwt
{
    public $chave;
    public $algorithm;
    public $expiration_time;

    public function __construct()
    {
        $this->chave = $_ENV["KEY"];
        $this->algorithm = "HS256";
        $this->expiration_time = 10;
    }

    public function pegarEnv()
    {
        return $this->chave;
    }

    public function verificarToken()
    {
        echo "akii";
    }

    public function generateToken($email)
    {
        $payload = [
            "iat" => time(),         // Emitido em
            "exp" => time() + $this->expiration_time, // Expiração
            "email" => $email
        ];

        return JWT::encode($payload, $this->chave, "HS256");
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->chave, $this->algorithm));
        } catch (Exception $e) {
            return false;
        }
    }
}

// // Simulação de login
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $json = file_get_contents("php://input");
//     $data = json_decode($json, true);

//     if ($data['username'] === 'admin' && $data['password'] === '1234') {
//         $token = AutenticacaoJwt::generateToken(1);
//         echo json_encode(["token" => $token]);
//     } else {
//         http_response_code(401);
//         echo json_encode(["error" => "Credenciais inválidas"]);
//     }
// }

// // Validação do token
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
//     $decoded = AutenticacaoJwt::validateToken($_GET['token']);
//     if ($decoded) {
//         echo json_encode(["message" => "Token válido", "data" => $decoded]);
//     } else {
//         http_response_code(401);
//         echo json_encode(["error" => "Token inválido"]);
//     }
// }