<?php
    // Configurações de conexão com o banco de dados
    $host = 'localhost';
    $db   = 'plushie_store';
    $user = 'root';
    $pass = ''; 
    $charset = 'utf8mb4';

    $mysqli = new mysqli($host, $user, $pass, $db);
    if ($mysqli->connect_error) {
        die('Erro de conexão: ' . $mysqli->connect_error);
    }
    $mysqli->set_charset($charset);
?>
