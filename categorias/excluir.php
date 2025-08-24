<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit();
}

$stmt = $mysqli->prepare("DELETE FROM categorias WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: index.php'); 
    exit();
} else {
    die("Erro ao deletar categoria: " . $mysqli->error);
}
?>
