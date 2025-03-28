<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    // Caso não esteja logado, redireciona para a página de login
    header('Location: ../login.php');
    exit();
}

require '../../app/controller/time.php';

$objUser = new Times_torneio();

// Buscar os times cadastrados pelo professor logado
$dados = $objUser->buscar('id_professor = ' . $_SESSION['id_professor']); // Apenas os times do professor logado
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Times Cadastrados</title>
    <link rel="stylesheet" href="../../assets/time2.css">
    <script src="../../assets/times.js" defer></script>
</head>
<body>
<div class="containerOpacity">
    <div class="container containerTitle">
        <h3 id="text1" class="spnTitle"></h3>
    </div>

    <?php
    // Verifica se não há times e exibe uma mensagem
    if (empty($dados)) {
        echo "<p>Nenhum time encontrado.</p>";
    } else {
        echo '<div class="times-list">';
        
        // Loop para exibir os times
        foreach ($dados as $index => $time) {
            $hasImage = $index !== 0;  // O primeiro time não terá imagem
            echo '<div class="card-container">';

            // Verifica se a propriedade id_times existe
            if (!isset($time->id_times)) {
                echo "<p>Erro: ID do time não encontrado.</p>";
                continue;
            }

            // Se não for o primeiro time, exibe a imagem
            if ($hasImage) {
                echo '<img src="../../assets/img/imgVS.png" alt="' . htmlspecialchars($time->nome) . '" class="card-image">';
            }

            // Link para o questionário da equipe
            echo '<a href="./questionario.php?id_time=' . $time->id_times . '" class="card-link">
                    <div class="card">
                        <div class="card-int">
                            <div class="hello">' . htmlspecialchars($time->nome) . '</div>
                            <span class="hidden">Entrar</span>
                        </div>
                    </div>
                  </a>';
            echo '</div>';
        }
        
        echo '</div>';
    }
    ?>
</div>
</body>
</html>
