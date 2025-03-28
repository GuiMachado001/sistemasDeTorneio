<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['resposta']) && !empty($_POST['resposta'])) {
        // Processar as respostas
        $respostas = $_POST['resposta'];
        
        // Inicializar a conexão com o banco de dados
        require '../../app/controller/desafios.php'; // Controller que interage com o banco

        // Obter o ID do time da sessão ou da URL
        require '../init.php';
        $id_time = $_SESSION['id_time'] ?? null; // Supondo que o id_time foi salvo na sessão

        foreach ($respostas as $id_desafio => $resposta) {
            // Buscar o desafio (pergunta) do banco de dados para obter a resposta correta
            $desafio = (new Desafio())->buscar_por_id($id_desafio);
            
            // Verificar se a resposta do usuário está correta
            if ($resposta == $desafio->resposta) {
                // Resposta correta, então registra os pontos
                $pontos = $desafio->pontos;

                // Inserir a pontuação na tabela 'pontuacao'
                $sql = "INSERT INTO pontuacao (id_times, id_desafio, pontos) 
                        VALUES (:id_times, :id_desafio, :pontos)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_times' => $id_time,
                    ':id_desafio' => $id_desafio,
                    ':pontos' => $pontos
                ]);

                echo "Resposta correta! Você ganhou $pontos pontos.";
            } else {
                echo "Resposta incorreta!";
            }
        }
    } else {
        echo "Nenhuma resposta foi selecionada.";
    }
}
?>
