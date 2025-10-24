<?php

require_once('./connection.php');

$stmt = $pdo->query('SELECT id, title FROM books');

while ($row = $stmt->fetch())
{
//    echo $row['title']. "<br>";
    echo "<a href='book.php?id={$row['id']}'>{$row['title']}</a><br>"; 

}