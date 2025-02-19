<?php

namespace app\controllers;

use app\models\Curriculo;

class CurriculoController
{
    private $curriculo;
    private $request;

    public function __construct()
    {
        $this->curriculo = new Curriculo;
        $this->request = $_REQUEST;
    }

    public function pegarTodos()
    {
        $usuarios = $this->curriculo->pegarTodos();
        return print_r(json_encode($usuarios));
    }

    public function pegarPorUsuarioId($usuario_id)
    {
        if (!is_numeric($usuario_id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Curriculo não encontrado"]));
        }

        $usuario = $this->curriculo->pegarPorUsuarioId($usuario_id);
        return print_r(json_encode($usuario));
    }

    public function pegarPorId($id)
    {
        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Curriculo não encontrado"]));
        }

        $usuario = $this->curriculo->pegarPorId($id);
        return print_r(json_encode($usuario));
    }


    public function cadastrar()
    {
        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        if (ValidacaoCurriculo::validar($this->request)) {
            return;
        }

        $imgCaminho = ValidacaoImagem::validar($img);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $this->request["img"] = $imgCaminho["msg"];
        }

        $cadastrar = $this->curriculo->cadastrar($this->request);
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

        $imgCaminho = ValidacaoImagem::validar($img);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $this->request["img"] = $imgCaminho["msg"];
        }

        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Usuario não encontrado"]));
        }

        $editar = $this->curriculo->editar($this->request);
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

        $excluir = $this->curriculo->excluir($this->request);
        if ($excluir->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $excluir->msg]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }
}