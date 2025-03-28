<?php
session_start();

// Verificar se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: ./index.php'); // Redireciona para a página de login
    exit(); // Interrompe a execução do script
}

require '../../app/controller/premiacoes.php';

if (isset($_GET['id_premiacao'])) {
    $id_premiacao = $_GET['id_premiacao'];
    $objPremiacao = new Premiacao();

    // Verifica se a premiação existe e pertence ao professor logado
    $premiacao = $objPremiacao->buscar_por_id($id_premiacao);
    if ($premiacao && $premiacao->id_professor == $_SESSION['id_professor']) {
        // Excluir a premiação
        $objPremiacao->id_premiacao = $id_premiacao;
        $res = $objPremiacao->excluir();
        if ($res) {
            echo "<script>alert('Premiação excluída com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao excluir premiação.');</script>";
        }
    } else {
        echo "<script>alert('Você não tem permissão para excluir esta premiação.');</script>";
    }
}

header('Location: listar_premiacao.php'); // Redireciona para a lista de premiações após a exclusão
exit;
?>
