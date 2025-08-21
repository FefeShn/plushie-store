<?php
// logout.php
session_start();
require_once 'includes/auth.php';

logout();
header('Location: login.php');
exit();
?>