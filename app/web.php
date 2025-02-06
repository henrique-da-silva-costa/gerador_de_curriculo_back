<?php

use app\controllers\UsuarioController;
use app\Rotas;

$router = new Rotas();

$router->get('/', function () {
    $usuario = new UsuarioController();

    return $usuario->pegarTodos();
});

$router->post('/cadastrar', function () {
    $usuario = new UsuarioController();
    return $usuario->cadastrar();
});

$router->post('/editar', function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

$router->post('/login', function () {
    $usuario = new UsuarioController();
    return $usuario->login();
});

$router->delete('/excluir', function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

return $router;