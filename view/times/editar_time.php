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

    $objUser = new Times_torneio();

    // Verifica se o time pertence ao professor logado
    $desc_edit = $objUser->buscar_por_id($id);
    
    // Se o time não for encontrado ou o professor não for o dono do time
    if ($desc_edit === null || $desc_edit->id_professor != $_SESSION['id_professor']) {
        // Caso não seja o professor logado, redireciona para a lista de times
        header('Location: listar_time.php');
        exit();
    }

    // --- Atualiza os dados
    if (isset($_POST['editar'])) {
        $nome = $_POST['nome'];
        $desc_edit->nome = $nome;

        // Atualiza o time
        $res = $desc_edit->atualizar();

        if ($res) {
            echo "<script>alert('Editado com Sucesso!');</script>";
            header('Location: ./listar_time.php');
            exit();
        } else {
            echo "<script>alert('Erro ao Editar!');</script>";
        }
    }
}

require './menuTimes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Editar Time</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Time</label>
                <!-- Corrigido: Garantindo que $desc_edit está sendo utilizado para exibir o nome do time -->
                <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($desc_edit->nome) ?>" required>
            </div>

            <button type="reset" class="btn btn-danger">Cancelar</button>
            <button type="submit" name="editar" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
