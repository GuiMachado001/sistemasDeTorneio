<?php
require './app/controller/professor.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Verificar se o formulário foi submetido
if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $objUser = new Professor();

    $objUser->nome = $nome;
    $objUser->senha = $senha;

    $res = $objUser->cadastrar();

    if($res){
      echo "<script>alert('Cadastrado com Sucesso') </script>";
    }else{
      echo "<script>alert('Erro ao Cadastrar') </script>";
    }
  }
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
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="text" class="form-control" name="senha" required>
            </div>

            <button type="reset" class="btn btn-danger">Cancelar</button>
            <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
