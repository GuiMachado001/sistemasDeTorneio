<?php
session_start();

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: ./index.php'); // Redireciona para a página de login
    exit(); // Interrompe a execução do script
}

require '../../app/controller/premiacoes.php';

// Criar instância de Premiacao e buscar todas as premiações
$objPremiacao = new Premiacao();
$dados = $objPremiacao->buscar();

require './menuPerguntas.php'; // Exibe o menu de navegação
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Premiações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>

    <div class="container">
        <h1 class="mt-4 text-center">Lista de Premiações</h1>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Pontos Necessários</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop para exibir todas as premiações
                foreach($dados as $premiacao){
                    echo '
                    <tr>
                        <th scope="row">'.$premiacao->id_premiacao.'</th>
                        <td>'.$premiacao->nome.'</td>
                        <td>'.$premiacao->descricao.'</td>
                        <td>'.$premiacao->pontos_necessarios.'</td>
                        <td>
                            <a class="btn btn-primary" href="./editar_premiacao.php?id_premiacao='.$premiacao->id_premiacao.'">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a class="btn btn-danger" href="./excluir_premiacao.php?id_premiacao='.$premiacao->id_premiacao.'">
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
