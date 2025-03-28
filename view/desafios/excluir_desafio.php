<?php
require '../init.php';

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: ./index.php'); // Redireciona para a página de login
    exit(); // Interrompe a execução do script
}

require '../../app/controller/desafios.php';

if (isset($_GET['id_desc'])) {
    $id_desc = $_GET['id_desc'];
    $objDesafio = new Desafio();

    // Verifica se o desafio existe e pertence ao professor logado
    $desafio = $objDesafio->buscar_por_id($id_desc);
    if ($desafio && $desafio->id_professor == $_SESSION['id_professor']) {
        // Excluir o desafio
        $objDesafio->id_desafio = $id_desc;
        $res = $objDesafio->excluir();
        if ($res) {
            echo "<script>alert('Desafio excluído com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao excluir desafio.');</script>";
        }
    } else {
        echo "<script>alert('Você não tem permissão para excluir este desafio.');</script>";
    }
}

header('Location: listar_desafio.php'); // Redireciona para a lista de desafios após a exclusão
exit;
?>
