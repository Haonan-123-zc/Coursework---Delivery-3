<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$login = trim($_POST['login']);
$password = trim($_POST['password']);

// seek user information
try {
    $stmt = $pdo->prepare("SELECT * FROM sellers WHERE username = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        die("<script>alert('Username,emai or password is false'); history.back();</script>");
    }

    // succeed to log-in,open Session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];

    // back to the first page
    header('Location: index.php');
} catch (PDOException $e) {
    die("Failed to log-in：" . $e->getMessage());
}
?>