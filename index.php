<?php

require_once('./connection.php');

$stmt = $pdo->query('SELECT title FROM books');
while ($row = $stmt->fetch())
{
//    echo $row['title']. "<br>";
    echo "<a href='book.php' id='title' >{$row['title']}</a><br>";

}