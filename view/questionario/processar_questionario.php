<?php
require_once '../init.php'; // Para inicializar variáveis e sessões
require_once '../../app/model/Database.php'; // Para incluir a classe de conexão com o banco

// Criar uma instância da classe Database
$database = new Database();
$pdo = $database->getConnection();  // Obter a conexão PDO com o banco de dados

ini_set('display_errors', 1);
error_reporting(E_ALL);


// Verificar se o ID do time está armazenado na sessão
if (!isset($_SESSION['id_time'])) {
    echo "Erro: Não foi possível encontrar o ID do time.";
    exit();
}

$id_time = $_SESSION['id_time'];

// Verificar se as respostas foram enviadas
if (isset($_POST['resposta'])) {
    // Loop através das respostas recebidas
    foreach ($_POST['resposta'] as $id_desafio => $resposta) {
        // Verificar se a resposta é válida
        if (!in_array($resposta, ['a', 'b', 'c', 'd', 'e'])) {
            echo "Resposta inválida para o desafio $id_desafio.";
            exit();
        }

        // Inserir a resposta no banco de dados
        try {
            // Buscar a resposta correta para o desafio
            $sql_resposta = "SELECT resposta FROM desafio WHERE id_desafio = :id_desafio";
            $stmt_resposta = $pdo->prepare($sql_resposta);
            $stmt_resposta->execute([':id_desafio' => $id_desafio]);

            // Se a resposta não for encontrada
            if ($stmt_resposta->rowCount() == 0) {
                echo "Desafio não encontrado.";
                exit();
            }

            $resposta_correta = $stmt_resposta->fetch(PDO::FETCH_ASSOC)['resposta'];

            // Verificar se a resposta está correta
            $pontos = ($resposta === $resposta_correta) ? 10 : 0; // 10 pontos para resposta correta

            // Inserir pontuação no banco de dados
            $sql = "INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (:id_times, :id_desafio, :pontos)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_times' => $id_time,
                ':id_desafio' => $id_desafio,
                ':pontos' => $pontos
            ]);

            // Armazenar a resposta na sessão
            $_SESSION['respostas'][$id_desafio] = $resposta;

        } catch (Exception $e) {
            // Exibir a mensagem de erro para depuração
            echo "Erro ao processar a resposta: " . $e->getMessage();
            exit();
        }
    }

    echo "Respostas enviadas com sucesso!";
} else {
    echo "Nenhuma resposta foi enviada.";
}
?>
