<?php
// auth.php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function login($username, $password) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT id, username, password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
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