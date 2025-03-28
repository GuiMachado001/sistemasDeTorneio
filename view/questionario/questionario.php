<?php
require '../init.php';
// Verificar se o ID do time foi passado na URL
if (isset($_GET['id_time'])) {
    $id_time = $_GET['id_time'];


    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);
    
    // Aqui você pode buscar os dados do time e exibir o questionário correspondente
    // Exemplo: buscar informações do time com o id_time, usando o seu modelo ou banco de dados
    // Exemplo fictício:
    // $time = buscarTimePorId($id_time);

    require '../../app/controller/desafios.php'; // Incluindo o controller que interage com o banco

    // Criar um objeto Desafio
    $desafio = new Desafio();
    
    // Buscar desafios (perguntas) de forma aleatória
    $desafios = $desafio->buscar(null, 'RAND()'); // 'RAND()' irá ordenar aleatoriamente as perguntas do banco de dados

    if (empty($desafios)) {
        echo "<p>Não há perguntas disponíveis para este time.</p>";
        exit();
    }

    // Limitar a 5 perguntas
    $desafios = array_slice($desafios, 0, 5);


    if (!isset($_SESSION['respostas'])) {
        $_SESSION['respostas'] = [];
    }
    
} else {
    // Se não houver ID de time, redireciona para uma página de erro ou a página inicial
    header('Location: escolhe_time.php'); // ou outra página de sua escolha
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionário</title>
    <link rel="stylesheet" href="../../assets/questinario.css">
    <script src="../../assets/questionario.js" defer></script>

</head>
<body>
    <h1>Questionário da Equipe</h1>

    <div class="container">
        
        <?php
        // Exibir as perguntas de forma aleatória
        $cont = 1;
        foreach ($desafios as $desafio_item) {
            // Verificar se a pergunta já foi respondida
            if (isset($_SESSION['respostas'][$desafio_item->id_desafio])) {
                echo "<p><strong>Pergunta " . $cont . " já foi respondida.</strong></p>";
                $cont++;
                continue; // Pular a exibição dessa pergunta
            }

            echo '<form action="./processar_questionario.php" method="POST">';
            
            echo '<div class="question">';
            echo '<span>' . $cont . ') </span>';
            echo '<span><strong>' . htmlspecialchars($desafio_item->enunciado) . '</strong></span>';
            
            // Exibir as opções de resposta
            echo '<div class="options">';
            echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="a"> a) ' . htmlspecialchars($desafio_item->opcaoA) . '</label>';
            echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="b"> b) ' . htmlspecialchars($desafio_item->opcaoB) . '</label>';
            echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="c"> c) ' . htmlspecialchars($desafio_item->opcaoC) . '</label>';
            echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="d"> d) ' . htmlspecialchars($desafio_item->opcaoD) . '</label>';
            echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="e"> e) ' . htmlspecialchars($desafio_item->opcaoE) . '</label>';
            echo '</div>';
            echo '</div>';

            // Adiciona o botão de envio para cada pergunta
            echo '<button type="button" class="cssbuttons-io-button" onclick="submitAnswer(<?php echo $desafio_item->id_desafio; ?>)">
                Enviar Resposta
                <div class="icon">
                    <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                    </svg>
                </div>
            </button>';

            // Fecha o formulário individual para cada pergunta
            echo '</form>';

            $cont += 1;
        }
        ?>
        
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function submitAnswer(idDesafio) {
    // Obter o formulário correspondente à pergunta
    var formData = $('#form_' + idDesafio).serialize(); // Serializa os dados do formulário
    
    $.ajax({
        url: './processar_questionario.php',  // O arquivo que processa as respostas
        type: 'POST',
        data: formData,  // Envia os dados do formulário
        success: function(response) {
            // Exibe o retorno da resposta
            alert(response);
            
            // Desabilita o botão de envio após a resposta
            $('#form_' + idDesafio).find('button').prop('disabled', true);
            
            // Desabilita as opções de resposta
            $('#form_' + idDesafio).find('input[type="radio"]').prop('disabled', true);
        },
        error: function() {
            alert('Ocorreu um erro. Tente novamente.');
        }
    });
}
</script>

</body>
</html>
