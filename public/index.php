<?php

require("../vendor/autoload.php");

use app\controllers\UsuarioController;

$usuario = new UsuarioController;

echo $usuario->nome;