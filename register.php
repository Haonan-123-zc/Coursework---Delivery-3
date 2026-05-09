<?php
require 'config.php';

// POST requirement only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.html');
    exit;
}

// get sheets data
$full_name = trim($_POST['full_name']);
$address = trim($_POST['address']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// validate all the input again
$errors = [];
if (!preg_match('/^[a-zA-Z\s]+$/', $full_name)) $errors[] = "Format of name is invalid";
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $address)) $errors[] = "Format of address is invalid";
if (!preg_match('/^1[3-9]\d{9}$/', $phone)) $errors[] = "Format of phonenumber is invalid";
if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|cn)$/', $email)) $errors[] = "Format of emai is invalid";
if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $username)) $errors[] = "Format of username is invalid";
if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $password)) $errors[] = "Format of password is invalid";

if (!empty($errors)) {
    die("Failed to register：" . implode("<br>", $errors));
}

// examine if the phonenumber/email/username has been used
try {
    $stmt = $pdo->prepare("SELECT id FROM sellers WHERE phone = ? OR email = ? OR username = ?");
    $stmt->execute([$phone, $email, $username]);
    if ($stmt->rowCount() > 0) {
        die("Failed to register：phonenumber/email/username has been used");
    }

    // password encryption storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // insert data
    $stmt = $pdo->prepare("INSERT INTO sellers (full_name, address, phone, email, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $address, $phone, $email, $username, $hashed_password]);

    // succeed to register,go to the log-in page
    echo "<script>alert('Succeed to register.Please log-in'); location.href='login.html';</script>";
} catch (PDOException $e) {
    die("Failed to register：" . $e->getMessage());
}
?>