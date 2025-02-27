<?php


namespace app\models;

use app\controllers\Tabelas;
use app\models\Banco;
use PDO;
use stdClass;

class Experiencia
{

    public $banco;
    public $tabela;

    public function __construct()
    {
        $this->banco = new Banco;
        $this->tabela = Tabelas::EXPERIENCIAS;
    }

    public function pegarTodosPorCurriculoIdPaginacao($curriculo_id)
    {
        try {
            $this->banco->conectar();
            $porPagina = 4;

            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($paginaAtual - 1) * $porPagina;

            $stmt = $this->banco->conexao->prepare("SELECT * FROM {$this->tabela} WHERE curriculo_id = :curriculo_id ORDER BY id DESC LIMIT :offset, :porPagina");
            $stmt->bindParam(':curriculo_id', $curriculo_id, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmtTotal = $this->banco->conexao->query("SELECT COUNT(*) as total FROM {$this->tabela} WHERE curriculo_id = $curriculo_id");
            $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

            $totalPaginas = ceil($total / $porPagina);

            return [
                'dados' => $dados,
                'paginaAtual' => $paginaAtual,
                'totalPaginas' => $totalPaginas
            ];
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarTodosPorCurriculoId($curriculo_id)
    {
        try {
            $this->banco->conectar();

            $stmt = $this->banco->conexao->prepare("SELECT * FROM {$this->tabela} WHERE curriculo_id = :curriculo_id ORDER BY id DESC");
            $stmt->bindParam(':curriculo_id', $curriculo_id, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarPorId($id)
    {
        try {
            $this->banco->conectar();

            $sql = "SELECT * FROM {$this->tabela} WHERE id = $id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $dados;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function cadastrar($dados)
    {
        try {
            $this->banco->conectar();

            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $empresa = isset($dados["empresa"]) ? $dados["empresa"] : NULL;
            $cargo = isset($dados["cargo"]) ? $dados["cargo"] : NULL;
            $responsabilidades = isset($dados["responsabilidades"]) ? $dados["responsabilidades"] : NULL;
            $habilidades = isset($dados["habilidades"]) ? $dados["habilidades"] : NULL;
            $data_inicio = isset($dados["data_inicio"]) ? $dados["data_inicio"] : NULL;
            $data_fim = isset($dados["data_fim"]) ? $dados["data_fim"] : NULL;
            $curriculo_id = isset($dados["curriculo_id"]) ? $dados["curriculo_id"] : NULL;

            $sql = "INSERT INTO {$this->tabela} (
            empresa,
            cargo,
            responsabilidades,
            habilidades,
            data_inicio,
            data_fim,
            curriculo_id) VALUES (
            :empresa,
            :cargo,
            :responsabilidades,
            :habilidades,
            :data_inicio,
            :data_fim,
            :curriculo_id
            )";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
            $stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
            $stmt->bindParam(":responsabilidades", $responsabilidades, PDO::PARAM_STR);
            $stmt->bindParam(":habilidades", $habilidades, PDO::PARAM_STR);
            $stmt->bindParam(":data_inicio", $data_inicio, PDO::PARAM_STR);
            $stmt->bindParam(":data_fim", $data_fim, PDO::PARAM_STR);
            $stmt->bindParam(":curriculo_id", $curriculo_id, PDO::PARAM_INT);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }

    public function editar($dados)
    {
        try {
            $this->banco->conectar();
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $empresa = isset($dados["empresa"]) ? $dados["empresa"] : NULL;
            $cargo = isset($dados["cargo"]) ? $dados["cargo"] : NULL;
            $responsabilidades = isset($dados["responsabilidades"]) ? $dados["responsabilidades"] : NULL;
            $habilidades = isset($dados["habilidades"]) ? $dados["habilidades"] : NULL;
            $data_inicio = isset($dados["data_inicio"]) ? $dados["data_inicio"] : NULL;
            $data_fim = isset($dados["data_fim"]) ? $dados["data_fim"] : NULL;
            $curriculo_id = isset($dados["curriculo_id"]) ? $dados["curriculo_id"] : NULL;

            if (!is_numeric($id)) {
                return;
            }

            $sql = "UPDATE {$this->tabela} SET
            empresa = :empresa,
            cargo = :cargo,
            responsabilidades = :responsabilidades,
            habilidades = :habilidades,
            data_inicio = :data_inicio,
            data_fim = :data_fim,
            curriculo_id = :curriculo_id WHERE id = :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
            $stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
            $stmt->bindParam(":responsabilidades", $responsabilidades, PDO::PARAM_STR);
            $stmt->bindParam(":habilidades", $habilidades, PDO::PARAM_STR);
            $stmt->bindParam(":data_inicio", $data_inicio, PDO::PARAM_STR);
            $stmt->bindParam(":data_fim", $data_fim, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":curriculo_id", $curriculo_id, PDO::PARAM_INT);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }

    public function excluir($dados)
    {
        try {
            $this->banco->conectar();
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $id = isset($dados["id"]) ? $dados["id"] : NULL;

            if (!is_numeric($id)) {
                return;
            }

            $sql = "DELETE FROM {$this->tabela} WHERE id = :id";
            $stmt = $this->banco->conexao->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }
}