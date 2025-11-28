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

$stmt = $pdo->prepare('SELECT first_name, last_name FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE book_id = :book_id;');
$stmt->execute(['book_id' => $id]);
$authors = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        ul li:last-child {
            border-bottom: none;
        }

        a, button {
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        a {
            background-color: #4CAF50;
            color: white;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049;
        }

        button {
            background-color: #f44336;
            color: white;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #d7372f;
        }

        form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $book['title']; ?></h1>

        <h3>Authors:</h3>
        <ul>
            <?php foreach ( $authors as $author ) { ?>
                <li><?= "{$author['first_name']} {$author['last_name']}"; ?></li>
            <?php } ?>
        </ul>
        <div>
            <h3>Book info</h3>
            <p>Year: <?= htmlspecialchars($book['release_date']) ?></p>
            <p>Type: <?= htmlspecialchars($book['type']) ?></p>
            <p>Language: <?= htmlspecialchars($book['language']) ?></p>
            <p>Price: <?= htmlspecialchars($book['price']) ?></p>
            <?php if (!empty($book['cover_path'])): ?>
            <p>Image:</p>
            <img src="<?= htmlspecialchars($book['cover_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" style="max-width:200px; height:auto;">
        </div>

        <a href="./edit.php?id=<?= $id; ?>">Change</a>

        <form action="./delete.php" method="post">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <button type="submit" name="action" value="delete">Delete</button>
        </form>

        <a href="index.php">Go back</a>
    </div>
</body>
</html>
<?php endif; ?>