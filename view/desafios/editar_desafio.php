<?php

require '../init.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require '../../app/controller/desafios.php';

// Verificar se existe um id de desafio para editar
if (isset($_GET['id_desc'])) {

    $id = $_GET['id_desc'];

    // Criar um objeto Desafio
    $objUser = new Desafio();

    // Buscar o desafio pelo ID
    $desc_edit = $objUser->buscar_por_id($id);

    // Verificar se o desafio foi encontrado
    if (!$desc_edit) {
        echo "<script>alert('Pergunta não encontrada!!'); window.location.href = './listar_desafio.php';</script>";
        exit();
    }

    // Se o formulário for enviado para editar o desafio
    if (isset($_POST['editar'])) {

        // Recuperar os dados do formulário
        $pontos = $_POST['pontos'];
        $enunciado = $_POST['enunciado'];
        $opcaoA = $_POST['opcaoA'];
        $opcaoB = $_POST['opcaoB'];
        $opcaoC = $_POST['opcaoC'];
        $opcaoD = $_POST['opcaoD'];
        $opcaoE = $_POST['opcaoE'];
        $resposta = $_POST['resposta'];

        // Atualizar as propriedades do objeto
        $desc_edit->pontos = $pontos;
        $desc_edit->enunciado = $enunciado;
        $desc_edit->opcaoA = $opcaoA;
        $desc_edit->opcaoB = $opcaoB;
        $desc_edit->opcaoC = $opcaoC;
        $desc_edit->opcaoD = $opcaoD;
        $desc_edit->opcaoE = $opcaoE;
        $desc_edit->resposta = $resposta;

        // Tentar atualizar o desafio
        $res = $desc_edit->atualizar();

        if ($res) {
            echo "<script>alert('Pergunta editada com sucesso'); window.location.href = './listar_desafio.php';</script>";
        } else {
            echo "<script>alert('Erro ao editar a pergunta');</script>";
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
    <title>Editar Desafio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>

<div class="container">
    <h1 class="mt-4 text-center">Edição de Pergunta</h1>
</div>

<div class="container">
    <form method="POST">

        <div class="mb-3">
            <label for="enunciado" class="form-label">Enunciado da pergunta</label>
            <input type="text" class="form-control" id="enunciado" name="enunciado" value="<?php echo htmlspecialchars($desc_edit->enunciado); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Respostas</label>
            <div class="row">
                <div class="col-2">
                    <label for="opcaoA">a)</label>
                    <input type="text" class="form-control" id="opcaoA" name="opcaoA" value="<?php echo htmlspecialchars($desc_edit->opcaoA); ?>" required>
                </div>
                <div class="col-2">
                    <label for="opcaoB">b)</label>
                    <input type="text" class="form-control" id="opcaoB" name="opcaoB" value="<?php echo htmlspecialchars($desc_edit->opcaoB); ?>" required>
                </div>
                <div class="col-2">
                    <label for="opcaoC">c)</label>
                    <input type="text" class="form-control" id="opcaoC" name="opcaoC" value="<?php echo htmlspecialchars($desc_edit->opcaoC); ?>" required>
                </div>
                <div class="col-2">
                    <label for="opcaoD">d)</label>
                    <input type="text" class="form-control" id="opcaoD" name="opcaoD" value="<?php echo htmlspecialchars($desc_edit->opcaoD); ?>" required>
                </div>
                <div class="col-2">
                    <label for="opcaoE">e)</label>
                    <input type="text" class="form-control" id="opcaoE" name="opcaoE" value="<?php echo htmlspecialchars($desc_edit->opcaoE); ?>" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="resposta" class="form-label">Escolha a Resposta Correta</label>
            <select class="form-control" name="resposta" id="resposta" required>
                <option value="" disabled>Selecione uma opção...</option>
                <option value="a" <?php echo $desc_edit->resposta == 'a' ? 'selected' : ''; ?>>a</option>
                <option value="b" <?php echo $desc_edit->resposta == 'b' ? 'selected' : ''; ?>>b</option>
                <option value="c" <?php echo $desc_edit->resposta == 'c' ? 'selected' : ''; ?>>c</option>
                <option value="d" <?php echo $desc_edit->resposta == 'd' ? 'selected' : ''; ?>>d</option>
                <option value="e" <?php echo $desc_edit->resposta == 'e' ? 'selected' : ''; ?>>e</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="pontos" class="form-label">Quantidade de pontos recebidos</label>
            <input type="number" class="form-control" id="pontos" name="pontos" value="<?php echo $desc_edit->pontos; ?>" required>
        </div>

        <button type="reset" class="btn btn-danger">Cancelar</button>
        <button type="submit" name="editar" class="btn btn-primary">Salvar</button>

    </form>
</div>

</body>
</html>
