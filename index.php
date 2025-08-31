<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$query = "SELECT p.*, c.nome_categoria 
            FROM produtos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id 
            ORDER BY p.id DESC 
            LIMIT 14";

$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include'includes/header.php';?>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="page-title">
            <h2>Bem-vindo ao Sistema de Gerenciamento</h2>
            <p>Gerencie seus produtos e categorias de pelúcias</p>
        </div>
        <div class="dashboard-cards">
            <div class="dash-card">
                <div class="dash-card-icon">
                    <i class="fas fa-box"></i>
                </div>
                <h3>Produtos</h3>
                <p>Gerencie seu inventário de pelúcias</p>
                <a href="produtos/index.php" class="btn btn-primary">Gerenciar Produtos</a>
            </div>
            <div class="dash-card">
                <div class="dash-card-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3>Categorias</h3>
                <p>Organize por categorias</p>
                <a href="categorias/index.php" class="btn btn-primary">Gerenciar Categorias</a>
            </div>
        </div>
        <div class="page-title">
            <h2>Nossas Pelúcias</h2>
            <p>Confira alguns produtos em destaque</p>
        </div>

        <div class="plushie-grid">
            <?php $result = $mysqli->query($query);

        if (!$result) {
            die("Erro na query: " . $mysqli->error);
        }
        ?>
            <?php if ($result->num_rows > 0): ?>
                <?php while($produto = $result->fetch_assoc()): ?>
                    <div class="plushie-card">
                        <div class="plushie-image">
                            <?php if (!empty($produto['imagem'])): ?>
                                <img src="assets/imagens/<?php echo $produto['imagem']; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                            <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <span>Sem imagem</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="plushie-info">
                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p class="plushie-category"><?php echo htmlspecialchars($produto['nome_categoria'] ?? 'Sem categoria'); ?></p>
                            <p class="plushie-description"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                            <div class="plushie-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                            <div class="plushie-actions">
                                <span class="<?php echo $produto['disponibilidade'] == 'disponível' ? 'available' : 'unavailable'; ?>">
                                    <?php echo $produto['disponibilidade'] == 'disponível' ? 'Disponível' : 'Indisponível'; ?>
                                </span>
                                <a href="produtos/editar.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary">Editar</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>Nenhum produto cadastrado</h3>
                    <p>Comece adicionando seus primeiros produtos!</p>
                    <a href="produtos/criar.php" class="btn btn-primary">Adicionar Produto</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include'includes/footer.php';?>
</body>
</html>