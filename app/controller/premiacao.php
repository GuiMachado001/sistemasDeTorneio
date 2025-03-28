<?php
require '../../app/model/Database.php';

class Premiacao {
    public int $id_premiacao;
    public string $descricao;
    public int $id_professor;

    // Método para cadastrar uma premiação
    public function cadastrar() {
        $db = new Database('premiacao');
        
        // Obter o ID do professor da sessão
        session_start();
        $id_professor = $_SESSION['id_professor'];

        // Associamos o id_professor à premiação
        $res = $db->insert(
            [
                'descricao' => $this->descricao,
                'id_professor' => $id_professor  // Associando o id_professor
            ]
        );
        return $res;
    }

    // Método para buscar premiações
    public function buscar($where = null, $order = null, $limit = null) {
        session_start();
        $id_professor = $_SESSION['id_professor'];  // Pega o ID do professor da sessão
        
        // Alterar o where para filtrar pelas premiações do professor logado
        $where = "id_professor = $id_professor";  // Garantir que estamos buscando apenas as premiações do professor logado
        
        $db = new Database('premiacao');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }

    // Método para buscar uma premiação pelo ID
    public function buscar_por_id($id) {
        $db = new Database('premiacao');

        $obj = $db->select('id_premiacao ='.$id)->fetchObject(self::class);
        return $obj; // Retorna um objeto da classe Premiacao
    }

    // Método para atualizar uma premiação
    public function atualizar() {
        $db = new Database('premiacao');

        $res = $db->update(
            "id_premiacao =".$this->id_premiacao,
            [
                "descricao" => $this->descricao,
            ]
        );
        return $res;
    }

    // Método para excluir uma premiação
    public function excluir() {
        $db = new Database('premiacao');

        $res = $db->delete('id_premiacao ='.$this->id_premiacao);
        return $res;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Premiação</title>
</head>
<body>
        
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $premiacao = new Premiacao();
        $premiacao->descricao = $_POST['descricao'];
        
        if ($premiacao->cadastrar()) {
            echo "<p>Prêmio cadastrado com sucesso!</p>";
        } else {
            echo "<p>Erro ao cadastrar prêmio.</p>";
        }
    }
    ?>
</body>
</html>
