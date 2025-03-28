<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
     <!-- Button de hamburguer -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>  <!-- Button de hamburguer -->
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="../dashboard.php">Dashboard</a>
        </li>

        <li class="nav-item dropdown">
           <!-- Dropdown link para Desafios -->
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownPremiacoes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Premiações
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownPremiacoes">
            <li class="nav-item">
              <a class="nav-link" href="./cadastrar_premiacao.php">Cadastrar Premiação</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./listar_premiacao.php">Listar Premiação</a>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <!-- Dropdown link para Times -->
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownDesafios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Desafios
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownDesafios">
            <li class="nav-item">
              <a class="nav-link" href="./cadastrar_desafio.php">Cadastrar Desafio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./listar_desafio.php">Listar Desafio</a>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownTimes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Times
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownTimes">
            <li class="nav-item">
              <a class="nav-link" href="../times/cadastrar_time.php">Cadastrar Times</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../times/listar_time.php">Listar Times</a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="../questionario/questionario.php">Questionário</a>
        </li>
      </ul>

      <!-- Botão de Logout com ícone -->
      <a href="../logout.php" class="btn btn-outline-light ms-3">
        <i class="bi bi-box-arrow-right"></i> Sair
      </a>
    </div>
  </div>
</nav>
