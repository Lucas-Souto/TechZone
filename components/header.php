<?php
require_once(dirname(__DIR__) . "/php/functions/getPath.php");

$iconPath = getPath("imgs/logo.png");
?>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark pt-2">
    <div class="container-fluid px-md-5 px-2">
      <div class="logo-div">
        <a href="../../index.php"><img class="logo-img" src="<?php echo $iconPath; ?>" /></a>
      </div>

      <a
        class="navbar-brand fs-1"
        style="color: var(--neon-green); font-size: 2.15em; font-family: 'Mukta', sans-serif;"
        href="../../index.php">
        TechZone
      </a>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <?php if (session_id()): ?>
            <li class="nav-item dropdown">
              <a class="nav-link fs-4 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
                Olá, <?php echo $_SESSION['fullname']; ?>!
              </a>

              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="../../pages/myAccount.php">Minha conta</a>

                <?php if ($_SESSION['status'] === 'admin'): ?>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../../pages/editUser.php">Editar usuário</a>
                  <a class="dropdown-item" href="../../pages/registerAdmin.php">Cadastrar novo usuário</a>
                  <a class="dropdown-item" href="../../pages/editProduct.php">Editar produto</a>
                  <a class="dropdown-item" href="../../pages/registerProduct.php">Cadastrar novo produto</a>
                  <div class="dropdown-divider"></div>
                <?php elseif ($_SESSION['status'] === 'collab'): ?>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../../pages/editProduct.php">Editar produto</a>
                  <a class="dropdown-item" href="../../pages/registerProduct.php">Cadastrar novo produto</a>
                  <div class="dropdown-divider"></div>
                <?php endif; ?>

                <a class="dropdown-item" href="../../php/handlers/exit.php">Sair</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link active fs-4 open-button" href="../../pages/shoppingCart.php">Carrinho</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link active fs-4 open-button" href="#" onclick="toggleLogin()">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active fs-4" href="../../pages/register.php">Cadastro</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>