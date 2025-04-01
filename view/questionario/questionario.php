<?php
require '../init.php';

// Verificar se o ID do time foi passado na URL e armazená-lo na sessão
if (isset($_GET['id_time'])) {
    $_SESSION['id_time'] = $_GET['id_time'];  
    $id_time = $_GET['id_time'];
} elseif (isset($_SESSION['id_time'])) {
    $id_time = $_SESSION['id_time']; 
} else {
    header('Location: escolhe_time.php');
    exit();
}

require '../../app/controller/desafios.php';

// Criar um objeto Desafio
$desafio = new Desafio();

// Buscar desafios aleatórios e limitar a 5 perguntas
$desafios = $desafio->buscar(null, 'RAND()');
$desafios = array_slice($desafios, 0, 5);

if (empty($desafios)) {
    echo "<p>Não há perguntas disponíveis para este time.</p>";
    exit();
}

// Garantir que as respostas sejam armazenadas separadamente por time
if (!isset($_SESSION['respostas'][$id_time])) {
    $_SESSION['respostas'][$id_time] = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionário</title>
    <link rel="stylesheet" href="../../assets/questinario.css">
    <script src="./questionario.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>Questionário da Equipe</h1>

    <div class="container">
        <form id="questionario_form" action="./processar_questionario.php" method="POST">
            <?php
            $cont = 1;
            foreach ($desafios as $desafio_item) {
                // Verificar se a pergunta já foi respondida por este time
                if (isset($_SESSION['respostas'][$id_time][$desafio_item->id_desafio])) {
                    echo "<p><strong>Pergunta " . $cont . " já foi respondida.</strong></p>";
                    $cont++;
                    continue;
                }

                echo '<div class="question">';
                echo '<span>' . $cont . ') </span>';
                echo '<span><strong>' . htmlspecialchars($desafio_item->enunciado) . '</strong></span>';

                echo '<div class="options">';
                echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="a" required> a) ' . htmlspecialchars($desafio_item->opcaoA) . '</label>';
                echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="b"> b) ' . htmlspecialchars($desafio_item->opcaoB) . '</label>';
                echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="c"> c) ' . htmlspecialchars($desafio_item->opcaoC) . '</label>';
                echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="d"> d) ' . htmlspecialchars($desafio_item->opcaoD) . '</label>';
                echo '<label><input type="radio" name="resposta[' . $desafio_item->id_desafio . ']" value="e"> e) ' . htmlspecialchars($desafio_item->opcaoE) . '</label>';
                echo '</div>';
                echo '</div>';

                $cont++;
            }
            ?>
            <button type="submit" class="cssbuttons-io-button">
                Enviar Respostas
                <div class="icon">
                    <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                    </svg>
                </div>
            </button>
        </form>
    </div>
</body>
</html>
