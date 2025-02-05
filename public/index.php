<?php

require("../vendor/autoload.php");
require_once("../app/web.php");

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
