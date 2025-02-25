<?php

namespace app\controllers;

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
        return print_r(json_encode([]));
    }

    public function login()
    {
        if (Validacao::validar($this->request)) {
            return;
        }

        $usuario = $this->usuario->exsiteUsuario($this->request);

        if (!$usuario) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "e-mail ou senha incorreto"]));
        }

        return print_r(json_encode($usuario));
    }

    public function recuperarSenha()
    {
        if (Validacao::validar($this->request)) {
            return;
        }

        $novaSenha = isset($this->request["novaSenha"]) ? $this->request["novaSenha"] : NULL;
        $comfirmaSenha = isset($this->request["confirmaSenha"]) ? $this->request["confirmaSenha"] : NULL;

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

        if ($novaSenha != $comfirmaSenha) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "as senha não são iguais"]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "senha recuperada com sucesso"]));
    }

    public function verificaremail()
    {
        if (Validacao::validar($this->request)) {
            return;
        }

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
}
