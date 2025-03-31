<?php
require '../init.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o ID do time foi passado na URL e armazená-lo na sessão
if (isset($_GET['id_time'])) {
    $_SESSION['id_time'] = $_GET['id_time'];  // Salvar ID na sessão
    $id_time = $_GET['id_time'];
} elseif (isset($_SESSION['id_time'])) {
    $id_time = $_SESSION['id_time']; // Se não veio na URL, usa o salvo na sessão
} else {
    header('Location: escolhe_time.php');
    exit();
}

require '../../app/controller/desafios.php';

// Criar um objeto Desafio
$desafio = new Desafio();

// Verificar se o time já tem um conjunto de perguntas armazenado na sessão
if (!isset($_SESSION['desafios'][$id_time])) {
    // Buscar desafios aleatórios e limitar a 5 perguntas
    $desafio_item = $desafio->buscar_por_id($id_desafio);

    $_SESSION['desafios'][$id_time] = array_slice($desafios, 0, 5); // Armazenar 5 perguntas aleatórias na sessão
} else {
    // Usar as perguntas armazenadas para o time
    $desafios = $_SESSION['desafios'][$id_time];
}

if (empty($desafios)) {
    echo "<p>Não há perguntas disponíveis para este time.</p>";
    exit();
}

// Inicializar a sessão de respostas para o time se ainda não existir
if (!isset($_SESSION['respostas'][$id_time])) {
    $_SESSION['respostas'][$id_time] = [];
}

// Verificar as respostas do formulário e calcular os pontos
$total_pontos = 0;
foreach ($_POST['resposta'] as $id_desafio => $resposta_usuario) {
    // Buscar o desafio correspondente
    $desafio_item = $desafio->buscarPorId($id_desafio);

    // Verificar se a resposta do usuário está correta
    if ($desafio_item->resposta === $resposta_usuario) {
        // Adicionar os pontos do desafio à pontuação total
        $total_pontos += $desafio_item->pontos;

        // Salvar a resposta no banco de dados ou na sessão (dependendo do seu design)
        $_SESSION['respostas'][$id_time][$id_desafio] = $resposta_usuario;

        // Atualizar a tabela de pontuação no banco de dados
        $sql = "UPDATE pontuacao SET pontos = ? WHERE id_times = ? AND id_desafio = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$total_pontos, $id_time, $id_desafio]);
    }
}

// Mostrar a pontuação total para o time
echo "Você obteve " . $total_pontos . " pontos.";
?>
