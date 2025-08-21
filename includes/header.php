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
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo">
                <i class="fas teddy-bear-icon"></i>
                <h1>Plushie Store</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="categorias.php">Categorias</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </nav>
            <div class="user-info">
                Olá, <?php echo $_SESSION['username']; ?>!
            </div>
        </div>
    </header>
    <main class="main-content"></main>