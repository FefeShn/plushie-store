<?php
// navbar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['nome'] ?? 'Usuário';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header class="header">
    <div class="logo">
        <div class="logo-icon">🧸</div>
        <h1>Plushie Store</h1>
    </div>
    
    <nav class="main-nav">
        <a href="/plushie-store/index.php" class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Início
        </a>
        <a href="/plushie-store/produtos/index.php" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'produtos') !== false) ? 'active' : ''; ?>">
            <i class="fas fa-box"></i> Produtos
        </a>
        <a href="/plushie-store/categorias/index.php" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'categorias') !== false) ? 'active' : ''; ?>">
            <i class="fas fa-tags"></i> Categorias
        </a>
    </nav>
    
    <div class="user-info">
        <span>Olá, <strong><?php echo htmlspecialchars($username); ?></strong></span>
        <a href="/plushie-store/logout.php" class="btn btn-primary">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>
    </div>
</header>