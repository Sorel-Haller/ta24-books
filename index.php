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

$stmt = $pdo->query('SELECT title FROM books');
while ($row = $stmt->fetch())
{
//    echo $row['title']. "<br>";
    echo "<a href='book.php' id='title' >{$row['title']}</a><br>";

}