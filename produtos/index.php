<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

// Buscar produtos + categoria (JOIN)
$query = "SELECT p.*, c.nome_categoria 
          FROM produtos p
          LEFT JOIN categorias c ON p.categoria_id = c.id
          ORDER BY p.id ASC";

$result = $mysqli->query($query);
if (!$result) {
    die("Erro na query: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include'../includes/header.php';?>
<body>
    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="main-container">
            <a href="criar.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Novo Produto</a>
            
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsiva">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Disponibilidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($produto = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $produto['id']; ?></td>
                                    <td>
                                        <?php if (!empty($produto['imagem'])): ?>
                                            <img src="../assets/imagens/<?php echo $produto['imagem']; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="produto-thumb">
                                        <?php else: ?>
                                            <div class="produto-thumb no-image">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                                    <td><?php echo htmlspecialchars($produto['nome_categoria'] ?? 'Sem categoria'); ?></td>
                                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                    <td>
                                        <span class="<?php echo $produto['disponibilidade'] == 'disponível' ? 'available' : 'unavailable'; ?>">
                                            <?php echo ucfirst($produto['disponibilidade']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="editar.php?id=<?php echo $produto['id']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="excluir.php?id=<?php echo $produto['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?');">
                                            <i class="fas fa-trash-alt"></i> Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>Nenhum produto cadastrado. <a href="criar.php">Clique aqui para adicionar um</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include'../includes/footer.php';?>
</body>
</html>
