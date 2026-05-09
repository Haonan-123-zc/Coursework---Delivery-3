<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car sale online - first page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Car sale online</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">Welcome<?= htmlspecialchars($_SESSION['full_name']) ?></span>
                <a href="logout.php" class="text-red-600 hover:underline">Log-out</a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-8">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to seller warehouse</h2>
            <p class="text-gray-600">Add your cars here</p>
        </div>
    </div>
</body>
</html>