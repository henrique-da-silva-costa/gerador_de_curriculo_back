<?php

namespace app\controllers;

use app\models\Usuario;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dotenv\Dotenv;

class UsuarioController
{
    private $usuario;
    private $request;

    public function __construct()
    {
        $this->usuario = new Usuario;
        $this->request = $_REQUEST;
    }

    public function pegarTodos()
    {
        $usuarios = $this->usuario->pegarTodos();
        return print_r(json_encode($usuarios));
    }

    public function login()
    {
        if (Validacao::validar($this->request)) {
            return;
        }

        $usuario = $this->usuario->exsiteUsuario($this->request);

        if (!$usuario) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "e-mail ou senha incorreto"]));
        }

        return print_r(json_encode($usuario));
    }

    public function recuperarSenha()
    {
        // if (Validacao::validar($this->request)) {
        //     return;
        // }

        $existeEmail = $this->usuario->existeEmail($this->request);

        if (!$existeEmail) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "esse email não existe"]));
        }

        $existeSenha = $this->usuario->existeSenha($this->request);

        if (!$existeSenha) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "essa senha não existe"]));
        }

        $recuperarSenha = $this->usuario->recuperarSenha($this->request);

        if ($recuperarSenha->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $recuperarSenha->msg]));
        }

        $novaSenha = isset($this->request["novaSenha"]) ? $this->request["novaSenha"] : NULL;
        $comfirmaSenha = isset($this->request["confirmaSenha"]) ? $this->request["confirmaSenha"] : NULL;

        if ($novaSenha != $comfirmaSenha) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "as senha não são iguais"]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "senha recuperada com sucesso"]));
    }

    public function verificaremail()
    {
        // if (Validacao::validar($this->request)) {
        //     return;
        // }

        $existeEmail = $this->usuario->existeEmail($this->request);

        if (!$existeEmail) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Esse email não existe"]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }

    public function cadastrar()
    {
        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        if (Validacao::validar($this->request)) {
            return;
        }

        $existe = $this->usuario->existeEmail($this->request);

        if ($existe) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "email já existe"]));
        }

        $imgCaminho = ValidacaoImagem::validar($img);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $this->request["img"] = $imgCaminho["msg"];
        }

        $cadastrar = $this->usuario->cadastrar($this->request);
        if ($cadastrar->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $cadastrar->msg]));
        }

        return print_r(json_encode(["erro" => FALSE, "msg" => "cadastro realizado com sucesso"]));
    }

    public function editar()
    {
        if (Validacao::validar($this->request)) {
            return;
        }

        $img = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        $id = isset($this->request["id"]) ? $this->request["id"] : NULL;

        if (!is_numeric($id)) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "Usuario não encontrado"]));
        }

        $existe = $this->usuario->existeEmail($this->request);

        if ($existe) {
            return print_r(json_encode(["erro" => TRUE, "msg" => "email já existe"]));
        }

        $imgCaminho = ValidacaoImagem::validar($img);

        if ($imgCaminho["erro"]) {
            return print_r(json_encode($imgCaminho));
        }

        foreach ($this->request as $valor) {
            $imgCaminho["erro"] ? $this->request["img"] = NULL : $this->request["img"] = $imgCaminho["msg"];
        }

        $editar = $this->usuario->editar($this->request);
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

        $excluir = $this->usuario->excluir($this->request);
        if ($excluir->erro) {
            return print_r(json_encode(["erro" => TRUE, "msg" => $excluir->msg]));
        }

        return print_r(json_encode(["erro" => FALSE]));
    }

    public function gerarPdf()
    {
        // reference the Dompdf namespace

        // instantiate and use the dompdf class
        $options = new Options();
        $options->set('defaultFont', 'arial');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml(


            "
        <style>
body{
    font-family: Arial, sans-serif;
}

        h1 {
            color: red;
        }
        </style>
        
        <body>
            <h1>Henrique</h1>
            <p>25</p>
            <p>henrique@live.com</p>
        </body>
        "

        );

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        // $dompdf->stream("preview.pdf", ["Attachment" => false]);
        $dompdf->stream();
    }
}
