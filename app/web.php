<?php

use app\controllers\UsuarioController;
use app\Rotas;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, AccountKey, X-Requested-With, Content-Type, Authorization, Client-Security-Token, Host, Date, Cookie, Cookie2');
header('Access-Control-Allow-Credentials: true');


$router = new Rotas();

$router->get('/', function () {
    $usuario = new UsuarioController();

    return $usuario->pegarTodos();
});

$router->get('/verificartoken', function () {
    $usuario = new UsuarioController();
    return $usuario->verificarToken();
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

$router->post('/recuperarsenha', function () {
    $usuario = new UsuarioController();
    return $usuario->recuperarSenha();
});

$router->post('/verificaremail', function () {
    $usuario = new UsuarioController();
    return $usuario->verificaremail();
});

$router->delete('/excluir', function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

return $router;