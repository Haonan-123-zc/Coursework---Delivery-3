<?php
session_start();
require 'config.php';

$keyword = $_GET['keyword'] ?? '';
$carList = [];

if (!empty($keyword)) {
    $sql = "SELECT brand, model, price, year FROM cars 
            WHERE brand LIKE :keyword OR model LIKE :keyword";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', "%$keyword%");
    $stmt->execute();
    $carList = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Result</title>
    <style>
        body {
            background: #111;
            color: #fff;
            text-align: center;
            padding: 50px;
            font-family: sans-serif;
        }
        .result-item {
            background: rgba(255,255,255,0.1);
            width: 400px;
            margin: 15px auto;
            padding: 20px;
            border-radius: 10px;
        }
        a {
            color: #0066ff;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>Search Results</h2>

    <?php if (count($carList) > 0): ?>
        <?php foreach ($carList as $car): ?>
            <div class="result-item">
                <h3><?= $car['brand'] ?> <?= $car['model'] ?></h3>
                <p>Price: £<?= $car['price'] ?></p >
                <p>Year: <?= $car['year'] ?></p >
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No matching car information found.</p >
    <?php endif; ?>

    <br>
    <a href=" ">Back to Search</a >
</body>
</html>