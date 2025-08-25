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

// Buscar categorias para o select
$categorias = $mysqli->query("SELECT id, nome_categoria FROM categorias ORDER BY nome_categoria ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria_id = $_POST['categoria_id'] ?? null;
    $preco = $_POST['preco'] ?? null;
    $disponibilidade = $_POST['disponibilidade'] ?? 'indisponível';
    $imagem = $_POST['imagem'] ?? ''; // apenas URL, simples

    if (empty($nome) || empty($descricao) || empty($categoria_id) || empty($preco)) {
        $error = 'Por favor, preencha todos os campos obrigatórios.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO produtos (nome, descricao, categoria_id, preco, disponibilidade, imagem) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdss", $nome, $descricao, $categoria_id, $preco, $disponibilidade, $imagem);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            $error = 'Erro ao criar produto: ' . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plushie Store - Novo Produto</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: .3rem;
        }
        input, textarea, select {
            width: 100%;
            padding: .5rem;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .radio-group {
            display: flex;
            gap: 1rem;
        }
        .preview-img {
            margin-top: .5rem;
            max-height: 120px;
            border: 1px solid #ddd;
            border-radius: 6px;
            display: none;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <main>
        <div class="main-container">

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="criar.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome do Produto:</label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoria:</label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="">Selecione</option>
                        <?php while($cat = $categorias->fetch_assoc()): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome_categoria']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="number" name="preco" id="preco" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Disponibilidade:</label>
                    <div class="radio-group">
                        <label><input type="radio" name="disponibilidade" value="disponível" checked> Disponível</label>
                        <label><input type="radio" name="disponibilidade" value="indisponível"> Indisponível</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="imagem">URL da Imagem:</label>
                    <input type="text" name="imagem" id="imagem" placeholder="https://exemplo.com/imagem.jpg" oninput="previewImage(this.value)">
                    <img id="preview" class="preview-img" alt="Prévia da imagem">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Produto</button>
            </form>
        </div>
    </main>

    <script>
        function previewImage(url) {
            const img = document.getElementById('preview');
            if (url) {
                img.src = url;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }
        }
    </script>
</body>
</html>
