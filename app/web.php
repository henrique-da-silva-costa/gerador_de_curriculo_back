<?php

use app\controllers\CurriculoController;
use app\controllers\CurriculoControlller;
use app\controllers\UsuarioController;
use app\Rotas;

$router = new Rotas();

// USUÁRIO
// USUÁRIO
// USUÁRIO

$router->get("/", function () {
    $usuario = new UsuarioController();

    return $usuario->pegarTodos();
});

$router->post("/cadastrar", function () {
    $usuario = new UsuarioController();
    return $usuario->cadastrar();
});

$router->post("/editar", function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

$router->post("/login", function () {
    $usuario = new UsuarioController();
    return $usuario->login();
});

$router->post("/recuperarsenha", function () {
    $usuario = new UsuarioController();
    return $usuario->recuperarSenha();
});

$router->post("/verificaremail", function () {
    $usuario = new UsuarioController();
    return $usuario->verificaremail();
});

$router->delete("/excluir", function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

// USUÁRIO
// USUÁRIO
// USUÁRIO

// CURRRICULO
// CURRRICULO
// CURRRICULO

$router->get("/curriculos", function () {
    $curriculo = new CurriculoController();

    return $curriculo->pegarTodos();
});

$router->post("/cadastrar/curriculo", function () {
    $curriculo = new CurriculoController();

    return $curriculo->cadastrar();
});

$router->post("/editar/curriculo", function () {
    $curriculo = new CurriculoController();
    return $curriculo->editar();
});

$router->delete("/excluir/curriculo", function () {
    $curriculo = new CurriculoController();
    return $curriculo->editar();
});

// CURRRICULO
// CURRRICULO
// CURRRICULO

return $router;
