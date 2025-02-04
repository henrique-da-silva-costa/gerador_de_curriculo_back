<?php

namespace app\controllers;

use app\models\Usuario;

class UsuarioController
{

    public $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario;
    }

    public function pegarTodos()
    {
        $usuarios = $this->usuario->pegarTodos();
        return $usuarios;
    }
}
