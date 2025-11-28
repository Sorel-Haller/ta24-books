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
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        div {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex-grow: 1;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        ul#book-list {
            list-style: none;
            padding: 0;
        }

        ul#book-list li {
            background-color: white;
            margin-bottom: 10px;
            padding: 12px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        ul#book-list li a.book {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
        }

        ul#book-list li a.book:hover {
            color: #4CAF50;
        }

        .hidden { display: none; }
    </style>
</head>
<body>
    <div>
        <input type="text" id="search" placeholder="Search">
        <a href="./add-author-form.php">
            <button>Add new author</button>
        </a>
    </div>
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
