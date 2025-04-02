<?php
require '../init.php';

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: ../login.php');
    exit();
}

require '../../app/controller/time.php';

$objUser = new Times_torneio();

// Buscar os times cadastrados pelo professor logado
$dados = $objUser->buscar('id_professor = ' . $_SESSION['id_professor']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipes Cadastradas</title>
    <link rel="stylesheet" href="../../assets/time2.css">
    <script src="../../assets/times.js" defer></script>
</head>
<body>
<div class="containerOpacity">
    <div class="container containerTitle">
        <h3 id="text1" class="spnTitle"></h3>
    </div>

    <?php
    if (empty($dados)) {
        echo "<p>Nenhuma equipe encontrada.</p>";
    } else {
        echo '<div class="times-list">';
        
        foreach ($dados as $index => $time) {
            $hasImage = $index !== 0;
            echo '<div class="card-container">';

            // Garante que a propriedade correta está definida
            if (!isset($time->id_times)) {
                echo "<p>Erro: ID da equipe não encontrado.</p>";
                continue;
            }

            if ($hasImage) {
                echo '<img src="../../assets/img/imgVS.png" alt="' . htmlspecialchars($time->nome) . '" class="card-image">';
            }

            // Corrigido: usando id_times corretamente
            echo '<a href="./questionario.php?id_time=' . $time->id_times . '" class="card-link">
                    <div class="card">
                        <div class="card-int">
                            <div class="hello">' . htmlspecialchars($time->nome) . '</div>
                            <span class="hidden">Acessar equipe</span>
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
