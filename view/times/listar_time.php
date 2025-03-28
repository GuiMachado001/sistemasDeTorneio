<?php
require '../init.php';
// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    // Caso não esteja logado, redireciona para a página de login
    header('Location: ../login.php');
    exit();
}

require '../../app/controller/time.php';

$objUser = new Times_torneio();

// Buscar os times cadastrados pelo professor logado
$dados = $objUser->buscar('id_professor = '.$_SESSION['id_professor']); // Apenas os times do professor logado

require './menuTimes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Times</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Lista de Times</h1>

        <!-- Exibir mensagem se não houver times cadastrados -->
        <?php if ($mensagem): ?>
            <div class="alert alert-warning"><?= $mensagem ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $time): ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars($time->id_times) ?></th>
                    <td><?= htmlspecialchars($time->nome) ?></td>
                    <td>
                        <a class="btn btn-primary" href="./editar_time.php?id_time=<?= $time->id_times ?>">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <a class="btn btn-danger" href="./excluir_time.php?id_time=<?= $time->id_times ?>">
                            <i class="bi bi-trash3"></i> Excluir
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
