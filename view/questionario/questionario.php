<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../app/controller/desafios.php';

// Verificar se existe um id de desafio para editar
if (!isset($_GET['id_desc'])) {
    echo "<script>alert('ID de desafio não fornecido!'); window.location.href = './listar_desafio.php';</script>";
    exit();
}

$id = $_GET['id_desc'];

// Criar um objeto Desafio
$objUser = new Desafio();

// Buscar o desafio pelo ID
$desc_edit = $objUser->buscar_por_id($id);

// Verificar se o desafio foi encontrado
if (!$desc_edit) {
    echo "<script>alert('Desafio não encontrado!'); window.location.href = './listar_desafio.php';</script>";
    exit();
}

// Perguntas de verdadeiro ou falso
$perguntas = [
    "O PHP é uma linguagem de script server-side?",
    "O HTML é uma linguagem de programação?",
    "O CSS é usado para estilizar páginas web?"
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Responda as Perguntas</h2>
    <form action="responder.php" method="POST">
        <?php foreach ($perguntas as $index => $pergunta): ?>
            <div class="mb-3">
                <label class="form-label"><?php echo ($index + 1) . ". " . $pergunta; ?></label><br>
                <input type="radio" name="pergunta_<?php echo $index; ?>" value="true" required> Verdadeiro
                <input type="radio" name="pergunta_<?php echo $index; ?>" value="false"> Falso
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Enviar Respostas</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
