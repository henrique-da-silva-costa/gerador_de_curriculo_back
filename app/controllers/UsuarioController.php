<?php

namespace app\controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, AccountKey, X-Requested-With, Content-Type, Authorization, Client-Security-Token, Host, Date, Cookie, Cookie2');
header('Access-Control-Allow-Credentials: true');

use app\models\Usuario;

class UsuarioController
{
    private $usuario;
    private $request;

    public function __construct()
    {
        $this->usuario = new Usuario;
        $this->request = $_REQUEST;
    }

    public function pegarTodos()
    {
        $usuarios = $this->usuario->pegarTodos();
        return print_r(json_encode($usuarios));
    }

    public function verificarToken()
    {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, AccountKey, X-Requested-With, Content-Type, Authorization');
        header('Access-Control-Allow-Credentials: true');

        print_r(json_encode(["erro" => FALSE]));
    }

    public function login()
    {
        $email = isset($this->request["email"]) ? $this->request["email"] : NULL;

        $auth = new AutenticacaoJwt;

        if (Validacao::validar($this->request)) {
            return;
        }

        $usuario = $this->usuario->exsiteUsuario($this->request);

        if (!$usuario) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "e-mail ou senha incorreto"]));
        }

        foreach ($usuario as $dado) {
            $usuario["env"] = $auth->generateToken($email);
        }

        return print_r(json_encode($usuario));
    }

    public function recuperarSenha()
    {
        // if (Validacao::validar($this->request)) {
        //     return;
        // }

        $existeEmail = $this->usuario->existeEmail($this->request);

        if (!$existeEmail) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "esse email não existe"]));
        }

        $existeSenha = $this->usuario->existeSenha($this->request);

        if (!$existeSenha) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "essa senha não existe"]));
        }

        $recuperarSenha = $this->usuario->recuperarSenha($this->request);

        if ($recuperarSenha->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $recuperarSenha->msg]));
        }

        $novaSenha = isset($this->request["novaSenha"]) ? $this->request["novaSenha"] : NULL;
        $comfirmaSenha = isset($this->request["confirmaSenha"]) ? $this->request["confirmaSenha"] : NULL;

        if ($novaSenha != $comfirmaSenha) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "as senha não são iguais"]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "senha recuperada com sucesso"]));
    }

    public function verificaremail()
    {
        // if (Validacao::validar($this->request)) {
        //     return;
        // }

        $existeEmail = $this->usuario->existeEmail($this->request);

        if (!$existeEmail) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Esse email não existe"]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }

    public function cadastrar()
    {
        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        if (Validacao::validar($this->request)) {
            return;
        }

        $existe = $this->usuario->existeEmail($this->request);

        if ($existe) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "email já existe"]));
        }

        $imgCaminho = ValidacaoImagem::validar($img);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $this->request["img"] = $imgCaminho["msg"];
        }

        $cadastrar = $this->usuario->cadastrar($this->request);
        if ($cadastrar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $cadastrar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "cadastro realizado com sucesso"]));
    }

    public function editar()
    {
        if (Validacao::validar($this->request)) {
            return;
        }

        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        $id = isset($this->request["id"]) ? $this->request["id"] : NULL;

        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Usuario não encontrado"]));
        }

        $existe = $this->usuario->existeEmail($this->request);

        if ($existe) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "email já existe"]));
        }

        $imgCaminho = ValidacaoImagem::validar($img);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $imgCaminho["erro"] ? $this->request["img"] = NULL : $this->request["img"] = $imgCaminho["msg"];
        }

        $editar = $this->usuario->editar($this->request);
        if ($editar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $editar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "edição realizada com sucesso"]));
    }

    public function excluir()
    {
        $id = isset($this->request["id"]) ? $this->request["id"] : NULL;

        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Usuario não encontrado"]));
        }

        $excluir = $this->usuario->excluir($this->request);
        if ($excluir->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $excluir->msg]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }
}