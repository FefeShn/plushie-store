<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$query = "SELECT * FROM categorias ORDER BY id ASC";
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
            <a href="criar.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nova Categoria</a>
            
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsiva">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome da Categoria</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($categoria = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $categoria['id']; ?></td>
                                    <td><?php echo htmlspecialchars($categoria['nome_categoria']); ?></td>
                                    <td class="actions">
                                        <a href="editar.php?id=<?php echo $categoria['id']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="excluir.php?id=<?php echo $categoria['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">
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
                    <p>Nenhuma categoria cadastrada. <a href="criar.php">Clique aqui para adicionar uma</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include'../includes/footer.php';?>
</body>
</html>