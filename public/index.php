<?php

use app\controllers\CurriculoController;
use app\controllers\UsuarioController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, Accept, AccountKey, X-Requested-With, Content-Type, Client-Security-Token, Host, Date, Cookie, Cookie2");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

require("../vendor/autoload.php");

$router = new AltoRouter();

// USUÁRIO
// USUÁRIO
// USUÁRIO

$router->map("GET", "/", function () {
    $usuario = new UsuarioController();

    return $usuario->pegarTodos();
});

$router->map("POST", "/cadastrar", function () {
    $usuario = new UsuarioController();
    return $usuario->cadastrar();
});

$router->map("POST", "/editar", function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

$router->map("POST", "/login", function () {
    $usuario = new UsuarioController();
    return $usuario->login();
});

$router->map("POST", "/recuperarsenha", function () {
    $usuario = new UsuarioController();
    return $usuario->recuperarSenha();
});

$router->map("POST", "/verificaremail", function () {
    $usuario = new UsuarioController();
    return $usuario->verificaremail();
});

$router->map("DELETE", "/excluir", function () {
    $usuario = new UsuarioController();
    return $usuario->editar();
});

// USUÁRIO
// USUÁRIO
// USUÁRIO

// CURRRICULO
// CURRRICULO
// CURRRICULO

$router->map("GET", "/curriculo/[i:usuario_id]", function ($usuario_id) {
    $curriculo = new CurriculoController();

    return $curriculo->pegarPorUsuarioId($usuario_id);
});

$router->map("GET", "/curriculoid/[i:id]", function ($id) {
    $curriculo = new CurriculoController();

    return $curriculo->pegarPorId($id);
});

$router->map("GET", "/curriculos", function () {
    $curriculo = new CurriculoController();

    return $curriculo->pegarTodos();
});

$router->map("POST", "/cadastrar/curriculo", function () {
    $curriculo = new CurriculoController();

    return $curriculo->cadastrar();
});

$router->map("POST", "/editar/curriculo", function () {
    $curriculo = new CurriculoController();
    return $curriculo->editar();
});

$router->map("OPTIONS", "/excluircurriculo", function () {
    $curriculo = new CurriculoController();
    return $curriculo->excluir();
});

// CURRRICULO
// CURRRICULO
// CURRRICULO

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // Página não encontrada
    http_response_code(404);
    print_r(json_encode("Página não encontrada!"));
}