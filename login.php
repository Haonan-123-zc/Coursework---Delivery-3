<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.html");
    exit();
}

$account = $_POST['account'];
$pwd = $_POST['pwd'];

$rule = '/^[A-Za-z0-9]{8,}$/';
if (!preg_match($rule, $account) || !preg_match($rule, $pwd)) {
    echo "<script>alert('Invalid account or password format'); history.back();</script>";
    exit();
}

$sql = "SELECT id, username, password FROM users WHERE username = :account LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':account', $account);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($pwd, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: index.html");
    exit();
} else {
    echo "<script>alert('Incorrect account or password'); history.back();</script>";
    exit();
}
?>