<?php
require '../init.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: ./index.php'); // Redireciona para a página de login
    exit(); // Interrompe a execução do script
}

require '../../app/controller/desafios.php';

// Criar instância de Desafio e buscar todos os desafios
$objUser = new Desafio();
$dados = $objUser->buscar();

require './menuPerguntas.php'; // Exibe o menu de navegação
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Desafios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>

    <div class="container">
        <h1 class="mt-4 text-center">Lista de Desafios</h1>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Enunciado</th>
                    <th scope="col">A)</th>
                    <th scope="col">B)</th>
                    <th scope="col">C)</th>
                    <th scope="col">D)</th>
                    <th scope="col">E)</th>
                    <th scope="col">Resposta</th>
                    <th scope="col">Pontos</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop para exibir todos os desafios
                foreach($dados as $desafio){
                    echo '
                    <tr>
                        <th scope="row">'.$desafio->id_desafio.'</th>
                        <td>'.$desafio->enunciado.'</td>
                        <td>'.$desafio->opcaoA.'</td>
                        <td>'.$desafio->opcaoB.'</td>
                        <td>'.$desafio->opcaoC.'</td>
                        <td>'.$desafio->opcaoD.'</td>
                        <td>'.$desafio->opcaoE.'</td>
                        <td>'.$desafio->resposta.'</td>
                        <td>'.$desafio->pontos.'</td>
                        <td>
                            <a class="btn btn-primary" href="./editar_desafio.php?id_desc='.$desafio->id_desafio.'">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a class="btn btn-danger" href="./excluir_desafio.php?id_desc='.$desafio->id_desafio.'">
                                <i class="bi bi-trash3"></i> Excluir
                            </a>
                        </td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
