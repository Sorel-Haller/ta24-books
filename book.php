<?php

require_once('./connection.php');

if (!isset($_GET['id']) || !$_GET['id']) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}
$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id= :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

var_dump($book);