<?php

require_once('./connection.php');
$stmt = $pdo->query('SELECT id, title FROM books WHERE is_deleted = 0');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
    <div>
        <input type="text" id="search" placeholder="Otsi">
    </div>
    <br>
    <ul id="book-list">

<?php
while ( $book = $stmt->fetch() ) {
?>

    <li>
        <a class="book" href="./book.php?id=<?= $book['id']; ?>">
            <?= $book['title']; ?>
        </a>
    </li>

<?php
}
?>

    </ul>
    <script src="app.js"></script>
</body>
</html>
