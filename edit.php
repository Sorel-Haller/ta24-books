<?php

require_once('./connection.php');

if ( !isset($_GET['id']) || !$_GET['id'] ) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT a.id, first_name, last_name FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE book_id = :book_id;');
$stmt->execute(['book_id' => $id]);
$bookAuthors = $stmt->fetchAll();
$bookAuthorIds = [];

$stmt = $pdo->query('SELECT * FROM authors');
$authors = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title']; ?> - Muuda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button[name="action"][value="save"], button[name="action"][value="add-author"] {
            background-color: #4CAF50;
            color: white;
        }

        button[name="action"][value="save"]:hover,
        button[name="action"][value="add-author"]:hover {
            background-color: #45a049;
        }

        button[name="action"][value="remove-author"] {
            background: none;
            border: none;
            color: #f44336;
            font-size: 18px;
            cursor: pointer;
            margin-left: 10px;
        }

        button[name="action"][value="remove-author"]:hover {
            color: #d7372f;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
        }

        ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        h3 {
            margin-top: 0;
            color: #555;
        }

        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Muuda raamatut: <?= $book['title']; ?></h1>

        <div class="section">
            <form action="update.php" method="post">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <label for="title">Raamatu pealkiri:</label>
                <input type="text" id="title" name="title" value="<?= $book['title']; ?>">
                <button type="submit" name="action" value="save">Salvesta</button>
            </form>
        </div>

        <div class="section">
            <h3>Autorid:</h3>
            <ul>
            <?php foreach ( $bookAuthors as $author ) {
                    $bookAuthorIds[] = $author['id']; ?>
                <li>
                    <?= "{$author['first_name']} {$author['last_name']}"; ?>
                    <form action="./remove-author.php" method="post" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?= $id; ?>">
                        <input type="hidden" name="author_id" value="<?= $author['id']; ?>">
                        <button type="submit" name="action" value="remove-author">✖</button>
                    </form>
                </li>
            <?php } ?>
            </ul>
        </div>
        
        <div class="section">
            <h3>Lisa autor:</h3>
            <form action="./add-author.php" method="post">
                <input type="hidden" name="book_id" value="<?= $id; ?>">
                <select name="author_id" required>
                    <option value="">-- vali autor --</option>
                    <?php foreach ( $authors as $author ) {
                        if ( !in_array($author['id'], $bookAuthorIds) ) { ?>
                        <option value="<?= $author['id']; ?>"><?= $author['first_name']; ?> <?= $author['last_name']; ?></option>
                    <?php }} ?>
                </select>
                <button type="submit" name="action" value="add-author">Lisa</button>
            </form>
        </div>
    </div>
</body>
</html>
