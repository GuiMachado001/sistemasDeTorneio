<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <!-- Button de hamburguer -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span> <!-- Icone de hamburguer -->
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="../dashboard.php">Dashboard</a>
        </li>
        
        <li class="nav-item dropdown">
          <!-- Dropdown link para Desafios -->
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownDesafios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Perguntas
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownDesafios">
                <li class="nav-item">
                <a class="nav-link" href="../desafios/cadastrar_desafio.php">Cadastrar Pergunta</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../desafios/listar_desafio.php">Listar Pergunta</a>
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
                    <a class="nav-link" href="./cadastrar_time.php">Cadastrar Times</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./listar_time.php">Listar Times</a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="../questionario/escolher_equipe.php">Questionario</a>
        </li>
      </ul>

      <!-- Botão de Logout com ícone -->
      <a href="../logout.php" class="btn btn-outline-light ms-3">
        <i class="bi bi-box-arrow-right"></i> Sair
      </a>
    </div>
  </div>
</nav>
