<?php

use app\controllers\CurriculoController;
use app\controllers\ExperienciaController;
use app\controllers\UsuarioController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, Accept, AccountKey, X-Requested-With, Content-Type, Client-Security-Token, Host, Date, Cookie, Cookie2");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

require("./vendor/autoload.php");

$router = new AltoRouter();

// USUÁRIO
// USUÁRIO
// USUÁRIO

$router->map("GET", "/", function () {
    return print_r(json_encode("Pagina inicial"));
});

$router->map("POST", "/cadastrar", function () {
    $usuario = new UsuarioController();
    return $usuario->cadastrar();
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

// USUÁRIO
// USUÁRIO
// USUÁRIO

// CURRRICULO
// CURRRICULO
// CURRRICULO

$router->map("GET", "/curriculo/[i:usuario_id]", function ($usuario_id) {
    $curriculo = new CurriculoController();

    return $curriculo->pegarPorCurriculoPorUsuarioId($usuario_id);
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

// CURRRICULO EXPERIENCIAS
// CURRRICULO EXPERIENCIAS
// CURRRICULO EXPERIENCIAS

// $router->map("GET", "/experiencias", function () {
//     $experiencia = new ExperienciaController();
//     return $experiencia->pegarTodos();
// });

$router->map("GET", "/experienciaspaginacao/[i:id]", function ($id) {
    $experiencia = new ExperienciaController();

    return $experiencia->pegarTodosPorCurriculoIdPaginacao($id);
});

$router->map("GET", "/experiencias/[i:id]", function ($id) {
    $experiencia = new ExperienciaController();

    return $experiencia->pegarTodosPorCurriculoId($id);
});

$router->map("GET", "/experiencia/[i:id]", function ($id) {
    $experiencia = new ExperienciaController();

    return $experiencia->pegarPorId($id);
});

$router->map("POST", "/cadastrar/experiencia", function () {
    $experiencia = new ExperienciaController();
    return $experiencia->cadastrar();
});

$router->map("POST", "/editar/experiencia", function () {
    $experiencia = new ExperienciaController();
    return $experiencia->editar();
});

$router->map("OPTIONS", "/excluirexperiencia", function () {
    $experiencia = new ExperienciaController();
    return $experiencia->excluir();
});

// CURRRICULO EXPERIENCIAS
// CURRRICULO EXPERIENCIAS
// CURRRICULO EXPERIENCIAS

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // Página não encontrada
    http_response_code(404);
    print_r(json_encode("Página não encontrada!"));
}