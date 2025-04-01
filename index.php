<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require './app/controller/professor.php';

$loginError = false; // Variável para controlar o erro no login

// Inicia a sessão para manipulação de variáveis de sessão
session_start();

if (isset($_POST['Login'])) {
    $nome = $_POST['Username'];
    $senha = $_POST['Password'];

    $objUser = new Professor();
    $objUser->nome = $nome;
    $objUser->senha = $senha;

    $res = $objUser->logar();

    if ($res) {
        // Login bem-sucedido, armazenar o id_professor na sessão
        $_SESSION['id_professor'] = $objUser->id_professor;
        
        // Redireciona para o dashboard ou outra página
        header('Location: ./view/dashboard.php');
        exit();
    } else {
        // Se login falhar, ativa o erro para exibição
        $loginError = true;
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/index.css">
</head>
<body>
    <div class="loginBox">
        <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
        <h3>Sign in here</h3>
        <form action="index.php" method="post">
            <div class="inputBox"> 
                <input id="uname" type="text" name="Username" placeholder="Username" required>
                <input id="pass" type="password" name="Password" placeholder="Password" required> 
            </div> 
            <input type="submit" name="Login" value="Login">
        </form>

        <a href="#">Forget Password<br> </a>
        <div class="text-center">
            <!-- <p style="color: #59238F;">Sign-Up</p> -->
            <a href="./cadastrar_usuario.php" style="color: #59238F;">Sing Up</a>
        </div>
    </div>

    <?php if ($loginError): ?>
        <!-- Chama o SweetAlert2 quando o login falha -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            title: 'Erro de login',
            text: 'Sua senha ou usuário está incorreto!',
            icon: 'error',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'index.php'; // Redireciona para a mesma página após o alerta
            }
        });
        </script>
    <?php endif; ?>

    <svg width="100%" height="100%" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" overflow="auto" shape-rendering="auto" fill="#ffffff">
  <defs>
   <path id="wavepath" d="M 0 2000 0 500 Q 105 421 210 500 t 210 0 210 0 210 0 210 0 210 0 210 0  v1000 z" />
   <path id="motionpath" d="M -420 0 0 0" /> 
  </defs>
  <g >
   <use xlink:href="#wavepath" y="183" fill="#115473">
   <animateMotion
    dur="5s"
    repeatCount="indefinite">
    <mpath xlink:href="#motionpath" />
   </animateMotion>
   </use>
  </g>
</svg>
		
</body>
</html>
