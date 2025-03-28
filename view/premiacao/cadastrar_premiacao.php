<?php
// Iniciar a sessão no início do arquivo
session_start();

// Verificar se o professor está logado (se o id_professor existe na sessão)
if (!isset($_SESSION['id_professor'])) {
    // Caso não esteja logado, redireciona para a página de login
    header('Location: ../login.php');
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../app/controller/premiacao.php';

// Verificar se o formulário foi submetido
if(isset($_POST['cadastrar'])){
    $descricao = $_POST['descricao'];
    $id_professor = $_SESSION['id_professor'];  // Obtém o ID do professor logado
    $id_desafio = $_POST['id_desafio'];  // Obtém o ID do desafio selecionado

    $objPremiacao = new Premiacao();
    $objPremiacao->descricao = $descricao;
    $objPremiacao->id_professor = $id_professor;  // Define o id_professor
    $objPremiacao->id_desafio = $id_desafio;      // Define o id_desafio

    // Chama o método de cadastro
    $res = $objPremiacao->cadastrar();

    if($res){
        echo "<script>alert('Premiação cadastrada com Sucesso!'); window.location.href = 'listar_premiacao.php';</script>";
    } else {
        echo "<script>alert('Erro ao Cadastrar Premiação!');</script>";
    }
}

require './menuPremiacao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Premiação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

<div class="container">
    <h1 class="mt-4 text-center">Cadastrar Premiação</h1>
    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição da Premiação</label>
            <input type="text" class="form-control" name="descricao" required>
        </div>

        <button type="reset" class="btn btn-danger">Cancelar</button>
        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
    </form>
</div>

</body>
</html>
