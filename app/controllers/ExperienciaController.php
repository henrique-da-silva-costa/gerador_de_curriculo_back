<?php

namespace app\controllers;

use app\models\Experiencia;

class ExperienciaController
{
    private $experiencia;
    private $request;

    public function __construct()
    {
        $this->experiencia = new Experiencia();
        $this->request = $_REQUEST;
    }

    public function pegarTodosPorCurriculoId($id)
    {
        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Curriculo não encontrado"]));
        }

        $usuario = $this->experiencia->pegarTodosPorCurriculoId($id);
        return print_r(json_encode($usuario));
    }

    public function pegarPorId($id)
    {
        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Experiencia não encontrada"]));
        }

        $usuario = $this->experiencia->pegarPorId($id);
        return print_r(json_encode($usuario));
    }

    public function cadastrar()
    {
        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        if (ValidacaoCurriculo::validar($this->request)) {
            return;
        }

        $imgCaminho = ValidacaoImagem::validar($img, TRUE);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $this->request["img"] = $imgCaminho["msg"];
        }

        $cadastrar = $this->experiencia->cadastrar($this->request);
        if ($cadastrar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $cadastrar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "cadastro realizado com sucesso"]));
    }

    public function editar()
    {
        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;
        $id = isset($this->request["id"]) ? $this->request["id"] : NULL;

        if (ValidacaoCurriculo::validar($this->request)) {
            return;
        }

        $imgCaminho = ValidacaoImagem::validar($img, TRUE);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $this->request["img"] = $imgCaminho["msg"];
        }

        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Usuario não encontrado"]));
        }

        $editar = $this->experiencia->editar($this->request);
        if ($editar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $editar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "edição realizada com sucesso"]));
    }

    public function excluir()
    {
        $id = isset($this->request["id"]) ? $this->request["id"] : NULL;

        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Usuario não encontrado"]));
        }

        $excluir = $this->experiencia->excluir($this->request);
        if ($excluir->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $excluir->msg]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }
}
