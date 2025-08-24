<?php
// header.php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plushie Store - Sistema de Gerenciamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <div class="logo-icon">🧸</div>
            <h1>Plushie Store</h1>
        </div>
        <div class="user-info">
            <span>Olá, <strong><?php echo $_SESSION['username']; ?></strong></span>
            <a href="../logout.php" class="btn btn-primary">Sair</a>
        </div>
    </header>
    <main class="container">