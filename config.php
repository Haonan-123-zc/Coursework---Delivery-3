<?php
$host = 'localhost';
$dbname = 'Car sale online';
$db_user = 'root';     
$db_pass = 'root';    

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass,[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
session_start();
?>