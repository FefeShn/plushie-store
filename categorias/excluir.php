<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    $stmt = $mysqli->prepare("DELETE FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=Categoria excluída com sucesso!");
        exit();
    } else {
        if ($mysqli->errno == 1451) {
            $erro = "❌ Não é possível excluir esta categoria, pois ainda existem produtos vinculados a ela.";
        } else {
            $erro = "Erro ao excluir categoria: " . $stmt->error;
        }
    }

    $stmt->close();
} else {
    $erro = "ID inválido.";
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Erro ao excluir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="alert alert-danger shadow-lg p-4 rounded-3 text-center" style="max-width: 500px;">
        <h4 class="alert-heading">⚠️ Ops!</h4>
        <p><?= $erro ?></p>
        <hr>
        <a href="index.php" class="btn btn-primary">Voltar</a>
    </div>
</body>
</html>
