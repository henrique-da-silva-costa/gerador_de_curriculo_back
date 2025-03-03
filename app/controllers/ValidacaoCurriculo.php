<?php

namespace app\controllers;

use Carbon\Carbon;

date_default_timezone_set('America/Sao_Paulo');

class ValidacaoCurriculo
{
    private static $hoje;

    public function __construct()
    {
        $this->hoje = Carbon::now();
    }

    public static function validar($dados)
    {
        if (!is_array($dados)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Tipo de dado invalido"]));
        }

        $dataInicio = "";
        $dataFim = "";
        $dataNascimento = "";

        try {
            $dataNascimento = isset($dados["data_nascimento"]) ? Carbon::createFromFormat("Y-m-d", $dados["data_nascimento"]) : NULL;
        } catch (\Throwable $th) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Campo obrigatório/data invalida", "campo" => "data_nascimento"]));
        }

        try {
            $dataInicio = isset($dados["data_inicio"]) ? Carbon::createFromFormat("Y-m-d", $dados["data_inicio"]) : NULL;
        } catch (\Throwable $th) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Campo obrigatório/data invalida", "campo" => "data_inicio"]));
        }

        try {
            $dataFim = isset($dados["data_fim"]) ? Carbon::createFromFormat("Y-m-d", $dados["data_fim"]) : NULL;
        } catch (\Throwable $th) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Campo obrigatório/data invalida", "campo" => "data_fim"]));
        }

        foreach ($dados as $index => $dado) {
            // if (strlen($dado) < 1 && $index == "sexo") {
            //     return print_r(json_encode(["erro" => TRUE, "msg" => "campo obrigatorio", "campo" => "sexo"]));
            // }

            if (strlen($dado) < 1 && $index != "data_fim" && $index != "img") {
                return print_r(json_encode(["erro" => TRUE]));
            }

            if ($index == "data_nascimento") {
                $dataNascimento = Carbon::createFromFormat("Y-m-d", $dado);

                $idade = $dataNascimento->diffInYears(self::$hoje);

                if ($idade < 14) {
                    return print_r(json_encode(["erro" => TRUE, "msg" => "A pessoa tem menos que 14 anos, e não pode fazer um currículo", "campo" => $index]));
                }
            }

            if ($dataInicio) {
                if ($dataInicio->gt($dataFim)) {
                    return print_r(json_encode(["erro" => TRUE, "msg" => "A data de inicio não pode ser maior que a data final", "campo" => "data_inicio"]));
                }

                $diferencaDeAnos = $dataNascimento->diffInYears($dataInicio);

                if ($diferencaDeAnos < 14) {
                    return print_r(json_encode(["erro" => TRUE, "msg" => "A data de inicio não corresponde com a data de nascimento", "campo" => "data_inicio"]));
                }
            }

            if ($dataInicio && $dataFim) {
                $diferencaDeAnos = $dataInicio->diffInMonths($dataFim);

                if ($diferencaDeAnos < 3) {
                    return print_r(json_encode(["erro" => TRUE, "msg" => "A data de inicio não pode ser menor que 3 meses", "campo" => "data_inicio"]));
                }
            }

            if (strlen($dado) > 255 && $index != "img" && $index != "descricao") {
                return print_r(json_encode(["erro" => TRUE, "msg" => "limite maximo de caracteres 255"]));
            }

            if ($index == "descricao" || $index == "responsabilidades" && strlen($dado) > 4000) {
                return print_r(json_encode(["erro" => TRUE, "msg" => "limite maximo de caracteres 4000"]));
            }
        }
    }
}
