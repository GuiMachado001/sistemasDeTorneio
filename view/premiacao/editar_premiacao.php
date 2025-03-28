<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../app/controller/premiacao.php';

// Verificar se existe um ID de premiação para editar
if (isset($_GET['id_premiacao'])) {
    $id = $_GET['id_premiacao'];
    
    // Criar um objeto Premiacao
    $objPremiacao = new Premiacao();
    
    // Buscar a premiação pelo ID
    $premiacao_edit = $objPremiacao->buscar_por_id($id);
    
    // Verificar se a premiação foi encontrada
    if (!$premiacao_edit) {
        echo "<script>alert('Premiação não encontrada!'); window.location.href = './listar_premiacao.php';</script>";
        exit();
    }

    // Se o formulário for enviado para editar a premiação
    if (isset($_POST['editar'])) {
        $descricao = $_POST['descricao'];
        $id_desafio = $_POST['id_desafio'];

        // Atualizar as propriedades do objeto
        $premiacao_edit->descricao = $descricao;
        $premiacao_edit->id_desafio = $id_desafio;

        // Tentar atualizar a premiação
        $res = $premiacao_edit->atualizar();

        if ($res) {
            echo "<script>alert('Premiação editada com sucesso!'); window.location.href = './listar_premiacao.php';</script>";
        } else {
            echo "<script>alert('Erro ao editar a premiação.');</script>";
        }
    }
}

require './menuPerguntas.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Premiação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

<div class="container">
    <h1 class="mt-4 text-center">Editar Premiação</h1>
</div>

<div class="container">
    <form method="POST">
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição da Premiação</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo htmlspecialchars($premiacao_edit->descricao); ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_desafio" class="form-label">Desafio Relacionado</label>
            <select class="form-control" name="id_desafio" id="id_desafio" required>
                <option value="" disabled>Selecione um desafio...</option>
                <?php
                require '../../app/controller/desafios.php';
                $desafios = Desafio::listarTodos();
                foreach ($desafios as $desafio) {
                    $selected = ($desafio['id_desafio'] == $premiacao_edit->id_desafio) ? 'selected' : '';
                    echo "<option value='{$desafio['id_desafio']}' $selected>{$desafio['enunciado']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="reset" class="btn btn-danger">Cancelar</button>
        <button type="submit" name="editar" class="btn btn-primary">Salvar</button>
    </form>
</div>

</body>
</html>