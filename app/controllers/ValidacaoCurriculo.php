<?php

namespace app\controllers;

class ValidacaoCurriculo
{


    public static function validar($dados)
    {
        if (!is_array($dados)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Tipo de dado invalido"]));
        }

        foreach ($dados as $index => $dado) {
            if (strlen($dado) < 1 && $index != "data_fim") {
                return print_r(json_encode(["erro" => TRUE, "msg" => "campo vazio $index", "campo" => $index]));
            }

            if (strlen($dado) > 255) {
                return print_r(json_encode(["erro" => TRUE, "msg" => "limite maximo de caracteres 255"]));
            }
        }
    }
}
