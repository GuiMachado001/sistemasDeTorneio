<?php
session_start();  // Inicia a sessão

// Verifica se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    echo "Professor não está logado.";
    exit();  // Impede que o restante da página seja carregado se não estiver logado
}

$id_do_professor = $_SESSION['id_professor'];  // Agora você tem o ID do professor
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Link para o Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Link para o Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>

    <!-- Link para o CSS personalizado -->
    <link rel="stylesheet" href="../assets/styles.css" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <!-- Button de hamburguer -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span> <!-- Icone de hamburguer -->
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="">Dashboard</a>
        </li>
        
        <li class="nav-item dropdown">
          <!-- Dropdown link para Desafios -->
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownDesafios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pergunta
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownDesafios">
                <li class="nav-item">
                <a class="nav-link" href="./desafios/cadastrar_desafio.php">Cadastrar Pergunta</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./desafios/listar_desafio.php">Listar Pergunta</a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item dropdown">
            <!-- Dropdown link para Times -->
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownTimes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Times
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownTimes">
                <li class="nav-item">
                    <a class="nav-link" href="./times/cadastrar_time.php">Cadastrar Times</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./times/listar_time.php">Listar Times</a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="./questionario/escolher_equipe.php">Questionario</a>
        </li>
      </ul>

      <!-- Botão de Logout com ícone -->
      <a href="./logout.php" class="btn btn-outline-light ms-3">
        <i class="bi bi-box-arrow-right"></i> Sair
      </a>
    </div>
  </div>
</nav>



      <div class="containerTimes">
      </div>

      <div class="containerDashboard">
        <canvas id="myChart"></canvas>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js deve vir primeiro -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>  <!-- ApexCharts (se necessário) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jQuery -->
<script src="../assets/scripts.js"></script> <!-- Seu script personalizado -->


 

  </body>
</html>
