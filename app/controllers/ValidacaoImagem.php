<?php

namespace app\controllers;

class ValidacaoImagem
{
    public static function validar($arquivo, $imgCurriculo = FALSE)
    {
        $diretorio = "uploads/";

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        if (isset($_FILES["img"]) && strlen($_FILES["img"]["name"]) > 0) {
            $nomeArquivo = basename($arquivo["name"]);
            $caminhoFinal = $diretorio . $nomeArquivo;

            $tipoArquivo = strtolower(pathinfo($caminhoFinal, PATHINFO_EXTENSION));
            $tiposPermitidos = ["jpg", "jpeg", "png", "gif"];

            if ($nomeArquivo && !in_array($tipoArquivo, $tiposPermitidos)) {
                return ["erro" => TRUE, "msg" => "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.", "campo" => "img"];
            }

            if ($imgCurriculo) {
                if ($arquivo["size"] > 2 * 50 * 1024) {
                    return ["erro" => TRUE, "msg" => "Erro: O arquivo é muito grande (limite de 50KB).", "campo" => "img"];
                }
            }

            if ($arquivo["size"] > 2 * 1024 * 1024) {
                return ["erro" => TRUE, "msg" => "Erro: O arquivo é muito grande (limite de 2MB).", "campo" => "img"];
            }

            if (move_uploaded_file($arquivo["tmp_name"], $caminhoFinal)) {
                $conteudoArquivo = file_get_contents($caminhoFinal);
                $base64 = "data:image/$tipoArquivo;base64," . base64_encode($conteudoArquivo);

                if ($imgCurriculo) {
                    return ["erro" => FALSE, "msg" => $base64];
                }

                return ["erro" => FALSE, "msg" => $caminhoFinal];
            } else {
                return ["erro" => TRUE, "msg" => "Erro ao enviar o arquivo.", "campo" => "img"];
            }
        } else {
            return ["erro" => FALSE, "msg" => NULL];
        }
    }
}
