<?php

$host = 'd138177.mysql.zonevs.eu';
$db   = 'd138177_booksdb';
$user = 'd138177_books22';
$pass = 'Booksmysql22';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);
if (!isset($_GET['id']) || !$_GET['id']) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}
$id = $_GET['id'];

    echo $id;

$stmt = $pdo->prepare('SELECT * FROM books WHERE id= :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

var_dump($book);