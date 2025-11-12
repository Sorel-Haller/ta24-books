<?php

require_once('./connection.php');

$stmt = $pdo->query('SELECT id, title FROM books');

while ($row = $stmt->fetch())
{
//    echo $row['title']. "<br>";
    echo "<a href='book.php?id={$row['id']}'>{$row['title']}</a><br>"; 

}

 ?>

<!DOCTYPE html>html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raamatud</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <a href="add.php">
        <button>Lisa raamat</button>
    </a>
</body>
</html> 