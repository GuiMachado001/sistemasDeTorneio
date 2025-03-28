<?php
// Iniciar a sessão no início do arquivo
require '../init.php';

// Verificar se o professor está logado (se o id_professor existe na sessão)
if (!isset($_SESSION['id_professor'])) {
    // Caso não esteja logado, redireciona para a página de login
    header('Location: ../login.php');
    exit();
}



require '../../app/controller/time.php';

// Verificar se o formulário foi submetido
if(isset($_POST['cadastrar'])){
    $nome = $_POST['nome'];
    $id_professor = $_SESSION['id_professor'];  // Obtém o ID do professor logado

    $objTime = new Times_torneio();
    $objTime->nome = $nome;
    $objTime->id_professor = $id_professor;  // Define o id_professor

    // Chama o método de cadastro
    $res = $objTime->cadastrar();

    if($res){
        echo "<script>alert('Cadastrado com Sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao Cadastrar!');</script>";
    }
}

require './menuTimes.php';
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Cadastrar Time</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Time</label>
                <input type="text" class="form-control" name="nome" required>
            </div>

            <button type="reset" class="btn btn-danger">Cancelar</button>
            <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
