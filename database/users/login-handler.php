<?php

session_start();
include_once "../connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../login.php");
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Usuário e senha são obrigatórios.";
    header("Location: ../../login.php");
    exit;
}

try {
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        unset($_SESSION['login_error']);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_loggedin'] = true;

        header("Location: ../../index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Usuário ou senha inválidos.";
        header("Location: ../../login.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['login_error'] = "Erro no sistema. Tente novamente.";
    header("Location: ../../login.php");
    exit;
}
?>