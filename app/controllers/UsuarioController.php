<?php

namespace app\controllers;

use app\models\Usuario;
use ReturnTypeWillChange;

class UsuarioController
{
    private $usuario;
    private $request;

    public function __construct()
    {
        $this->usuario = new Usuario;
        $this->request  = $_REQUEST;
    }

    public function validar($dados)
    {
        foreach ($dados as $index => $dado) {
            if (strlen($dado) < 1) {
                return print_r(json_encode(["erro" => TRUE, "msg" => "campo vazio"]));
            }

            if (strlen($dado) > 255) {
                return print_r(json_encode(["erro" => TRUE, "msg" => "limite maximo de caracteres 255"]));
            }
        }
    }

    public function pegarTodos()
    {
        $usuarios = $this->usuario->pegarTodos();
        return $usuarios;
    }

    public function cadastrar()
    {
        if ($this->validar($this->request)) {
            return;
        }

        $existe = $this->usuario->existeEmail($this->request);

        if ($existe) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "email já existe"]));
        }

        $cadastrar = $this->usuario->cadastrar($this->request);
        if ($cadastrar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $cadastrar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }

    public function editar()
    {
        $editar = $this->usuario->editar($this->request);
        if ($editar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $editar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE]));
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
