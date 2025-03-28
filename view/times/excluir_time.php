<?php
// Iniciar a sessão
require '../init.php';

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    // Caso não esteja logado, redireciona para a página de login
    header('Location: ../login.php');
    exit();
}

require '../../app/controller/time.php';

if (isset($_GET['id_time'])) {
    $id = $_GET['id_time'];

    // Cria um objeto da classe Times_torneio
    $objUser = new Times_torneio();

    // Chama o método buscar_por_id e recupera o time
    $desc_delete = $objUser->buscar_por_id($id);

    // Verifica se o time pertence ao professor logado
    if ($desc_delete->id_professor != $_SESSION['id_professor']) {
        // Caso não seja o professor logado, redireciona para a lista de times
        header('Location: listar_time.php');
        exit();
    }

    // Agora chama o método excluirTime passando o ID
    $del = $objUser->excluirTime($id);

    if ($del) {
        header('Location: ./listar_time.php');
        exit();
    } else {
        echo "Erro ao excluir o time.";
    }
}
?>
