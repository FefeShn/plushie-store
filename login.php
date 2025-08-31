<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Por favor, preencha todos os campos';
    } else {
        if (login($email, $password)) {
            header('Location: index.php');
            exit();
        } else {
            $error = 'E-mail ou senha incorretos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Plushie Store</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="brand">
                <i class="fas teddy-bear-icon"></i>
                <h1>Plushie Store</h1>
            </div>
            
            <div class="welcome-message">
                <h2>Bem-vindo de volta!</h2>
                <p>Faça login para gerenciar seus produtos</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST" class="login-form">
                
                
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> E-mail
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        placeholder="Digite seu e-mail"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Senha
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Digite sua senha"
                    >
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </form>
            
        
        </div>
        
        <div class="login-decoration">
            <div class="decoration-item bear-1">
                <i class="fas fa-bear"></i>
            </div>
            <div class="decoration-item bear-2">
                <i class="fas fa-bear"></i>
            </div>
        </div>
    </div>
    <?php include'includes/footer.php';?>
</body>
</html>