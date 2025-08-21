<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <i class="fas fa-paw me-2"></i>Plushie Store
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="../index.php"><i class="fas fa-home me-1"></i> Início</a>
        </li>
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="products/index.php"><i class="fas fa-tshirt me-1"></i> Produtos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories/index.php"><i class="fas fa-tags me-1"></i> Categorias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="auth/logout.php"><i class="fas fa-sign-out-alt me-1"></i> Sair</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="../index.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>