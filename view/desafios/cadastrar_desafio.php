<?php
require '../init.php';


// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: ./index.php'); // Redireciona para a página de login
    exit(); // Interrompe a execução do script
}

require '../../app/controller/desafios.php';

if (isset($_POST['cadastrar'])) {
    $pontos = $_POST['pontos'];
    $enunciado = $_POST['enunciado'];
    $opcaoA = $_POST['opcaoA'];
    $opcaoB = $_POST['opcaoB'];
    $opcaoC = $_POST['opcaoC'];
    $opcaoD = $_POST['opcaoD'];
    $opcaoE = $_POST['opcaoE'];
    $resposta = $_POST['resposta'];

    $objUser = new Desafio();

    // Definindo as propriedades do objeto Desafio
    $objUser->pontos = $pontos;
    $objUser->enunciado = $enunciado;
    $objUser->opcaoA = $opcaoA;
    $objUser->opcaoB = $opcaoB;
    $objUser->opcaoC = $opcaoC;
    $objUser->opcaoD = $opcaoD;
    $objUser->opcaoE = $opcaoE;
    $objUser->resposta = $resposta;

    // Cadastrando o desafio
    $res = $objUser->cadastrar();

    if ($res) {
        echo "<script>alert('Cadastrado com Sucesso'); window.location.href = 'listar_desafio.php'; </script>";
    } else {
        echo "<script>alert('Erro ao Cadastrar'); </script>";
    }
}

require './menuPerguntas.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Desafio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>


<div class="container">
    <h1 class="mt-4 text-center">Cadastrar Desafio</h1>
</div>

<div class="container">
    <form method="POST" enctype="multipart/form-data">


        <div class="mb-3">
            <label for="enunciado" class="form-label">Enunciado da pergunta</label>
            <input type="text" class="form-control" id="enunciado" name="enunciado" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Respostas</label>
            <div class="row">
                <div class="col-2"><label>a)</label><input type="text" class="form-control" name="opcaoA" required></div>
                <div class="col-2"><label>b)</label><input type="text" class="form-control" name="opcaoB" required></div>
                <div class="col-2"><label>c)</label><input type="text" class="form-control" name="opcaoC" required></div>
                <div class="col-2"><label>d)</label><input type="text" class="form-control" name="opcaoD" required></div>
                <div class="col-2"><label>e)</label><input type="text" class="form-control" name="opcaoE" required></div>
            </div>
        </div>

        <div class="mb-3">
            <label for="resposta" class="form-label">Escolha a Resposta Correta</label>
            <select class="form-control" name="resposta" id="resposta" required>
                <option value="" disabled selected>Selecione uma opção...</option>
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
                <option value="d">d</option>
                <option value="e">e</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nome" class="form-label">Quantidade de pontos recebidos</label>
            <input type="number" class="form-control" id="pontos" name="pontos" required>
        </div>


        <button type="reset" class="btn btn-danger">Cancelar</button>
        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
    </form>
</div>

</body>
</html>