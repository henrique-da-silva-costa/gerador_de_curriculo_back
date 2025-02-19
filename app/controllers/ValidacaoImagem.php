<?php

namespace app\controllers;

class ValidacaoImagem
{
    public static function validar($arquivo)
    {
        // Diretório onde a imagem será salva
        $diretorio = "uploads/";

        // Verifica se o diretório existe, caso contrário, cria
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        // Verifica se um arquivo foi enviado
        if (isset($_FILES["img"]) && strlen($_FILES["img"]["name"]) > 0) {
            $nomeArquivo = basename($arquivo["name"]);
            $caminhoFinal = $diretorio . $nomeArquivo;

            // Verifica se o arquivo é uma imagem
            $tipoArquivo = strtolower(pathinfo($caminhoFinal, PATHINFO_EXTENSION));
            $tiposPermitidos = ["jpg", "jpeg", "png", "gif"];

            if ($nomeArquivo && !in_array($tipoArquivo, $tiposPermitidos)) {
                return ["erro" => TRUE, "msg" => "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos."];
            }

            // Verifica o tamanho do arquivo (limite de 2MB)
            if ($arquivo["size"] > 2 * 1024 * 1024) {
                return ["erro" => TRUE, "msg" => "Erro: O arquivo é muito grande (limite de 2MB)."];
            }

            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($arquivo["tmp_name"], $caminhoFinal)) {
                return ["erro" => FALSE, "msg" => $caminhoFinal];
            } else {
                return ["erro" => TRUE, "msg" => "Erro ao enviar o arquivo."];
            }
        } else {
            return ["erro" => FALSE, "msg" => "Nenhum arquivo foi enviado."];
        }
    }
}