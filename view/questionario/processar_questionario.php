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

// Variável para armazenar a pontuação total
$pontos_totais = 0;

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
            // Buscar a resposta correta e os pontos para o desafio
            $sql_resposta = "SELECT resposta, pontos FROM desafio WHERE id_desafio = :id_desafio";
            $stmt_resposta = $pdo->prepare($sql_resposta);
            $stmt_resposta->execute([':id_desafio' => $id_desafio]);

            // Se a resposta não for encontrada
            if ($stmt_resposta->rowCount() == 0) {
                echo "Desafio não encontrado.";
                exit();
            }

            $dados_desafio = $stmt_resposta->fetch(PDO::FETCH_ASSOC);
            $resposta_correta = $dados_desafio['resposta'];
            $pontos = $dados_desafio['pontos'];

            // Verificar se a resposta está correta
            if ($resposta === $resposta_correta) {
                // Se acertou, adicionar os pontos ao total
                $pontos_totais += $pontos;
            }

            // Armazenar a resposta na sessão
            $_SESSION['respostas'][$id_desafio] = $resposta;

        } catch (Exception $e) {
            // Exibir a mensagem de erro para depuração
            echo "Erro ao processar a resposta: " . $e->getMessage();
            exit();
        }
    }

    // Após o loop, inserir a pontuação total do time
    try {
        // Inserir a pontuação total no banco de dados
        $sql_pontuacao_total = "INSERT INTO pontuacao (id_times, pontos) VALUES (:id_times, :pontos_totais)";
        $stmt_pontuacao = $pdo->prepare($sql_pontuacao_total);
        $stmt_pontuacao->execute([
            ':id_times' => $id_time,
            ':pontos_totais' => $pontos_totais
        ]);

        echo "Respostas enviadas com sucesso! Pontuação total: $pontos_totais pontos.";
    } catch (Exception $e) {
        echo "Erro ao armazenar pontuação total: " . $e->getMessage();
    }

} else {
    echo "Nenhuma resposta foi enviada.";
}
