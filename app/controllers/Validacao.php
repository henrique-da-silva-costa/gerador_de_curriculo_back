<?php

namespace app\controllers;

class Validacao
{
    const INPUTS = ["nome", "email", "senha", "novaSenha", "comfirmaSenha"];

    public static function validar($dados)
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        if (!is_array($dados)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Tipo de dado invalido"]));
        }

        // if (!isset($dados["nome"])) {
        //     return print_r(json_encode(["erro" => TRUE, "msg" => "campo obrigatório"]));
        // }

        // if (!isset($dados["email"])) {
        //     return print_r(json_encode(["erro" => TRUE, "msg" => "campo obrigatório"]));
        // }

        // if (!isset($dados["senha"])) {
        //     return print_r(json_encode(["erro" => TRUE, "msg" => "campo obrigatório"]));
        // }

        foreach ($dados as $index => $dado) {
            if (strlen($dado) < 1 && $index != "img") {
                return print_r(json_encode(["erro" => TRUE, "msg" => "campo vazio $index", "campo" => $index]));
            }

            if ($index == "email" && !preg_match($regex, $dado)) {
                return print_r(json_encode(["erro" => TRUE, "msg" => "tipo de email inválido", "campo" => $index]));
            }

            if (strlen($dado) > 255) {
                return print_r(json_encode(["erro" => TRUE, "msg" => "limite maximo de caracteres 255"]));
            }
        }
    }
}
