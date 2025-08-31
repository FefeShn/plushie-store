<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_categoria = trim($_POST['nome_categoria'] ?? '');

    if (empty($nome_categoria)) {
        $error = 'Por favor, preencha o nome da categoria.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO categorias (nome_categoria) VALUES (?)");
        $stmt->bind_param("s", $nome_categoria);

        if ($stmt->execute()) {
            $success = 'Categoria criada com sucesso!';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Erro ao criar categoria: ' . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include'../includes/header.php';?>
<body>
    <?php include '../includes/navbar.php'; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form action="criar.php" method="POST">
        <div class="form-group">
            <label for="nome_categoria">Nome da Categoria:</label>
            <input type="text" name="nome_categoria" id="nome_categoria" required>
        </div>
        <button type="submit">Salvar</button>
    </form>
    <?php include'../includes/footer.php';?>
</body>
</html>
