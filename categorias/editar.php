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

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit();
}

$stmt = $mysqli->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_categoria = trim($_POST['nome_categoria'] ?? '');

    if (empty($nome_categoria)) {
        $error = 'Por favor, preencha o nome da categoria.';
    } else {
        $stmt = $mysqli->prepare("UPDATE categorias SET nome_categoria = ? WHERE id = ?");
        $stmt->bind_param("si", $nome_categoria, $id);

        if ($stmt->execute()) {
            $success = 'Categoria atualizada com sucesso!';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Erro ao atualizar categoria: ' . $mysqli->error;
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

    <form action="editar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="nome_categoria">Nome da Categoria:</label>
            <input type="text" name="nome_categoria" id="nome_categoria" value="<?php echo htmlspecialchars($categoria['nome_categoria']); ?>" required>
        </div>
        <button type="submit">Salvar Alterações</button>
    </form>
    <?php include'../includes/footer.php';?>
</body>
</html>
