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
        return print_r(json_encode($usuarios));
    }

    public function login()
    {
        $usuario = $this->usuario->exsiteUsuario($this->request);

        if (!$usuario) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "e-mail ou senha incorreto"]));
        }

        return print_r(json_encode($usuario));
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
            print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $imgCaminho["erro"] ? $this->request["img"] = NULL : $this->request["img"] = $imgCaminho["msg"];
        }

        $cadastrar = $this->usuario->cadastrar($this->request);
        if ($cadastrar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $cadastrar->msg]));
        }

        return;
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
            print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $imgCaminho["erro"] ? $this->request["img"] = NULL : $this->request["img"] = $imgCaminho["msg"];
        }

        $editar = $this->usuario->editar($this->request);
        if ($editar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $editar->msg]));
        }

        return;
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