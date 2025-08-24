<?php
// auth.php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function login($email, $password) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
    if (!$stmt) {
        die("Erro no prepare: " . $mysqli->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if ($password === $user['senha']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];
            return true;
        }
    }
    
    return false;
}

function logout() {
    session_unset();
    session_destroy();
}
?>
