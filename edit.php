<?php

require_once('./connection.php');

if ( !isset($_GET['id']) || !$_GET['id'] ) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $price = $_POST['price'];
    $language = $_POST['language'];
    $type = $_POST['type'];
    $cover_path = $_POST['cover_path'];

    $stmt = $pdo-> prepare('UPDATE books SET price = :price, language = :language, type = :type, cover_path = :cover_path WHERE id= :id');
    $stmt->execute([
        'id' => $id,
        'price' => $price,
        'language' => $language,
        'type' => $type,
        'cover_path' => $cover_path,
    ]);
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT a.id, first_name, last_name FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE book_id = :book_id;');
$stmt->execute(['book_id' => $id]);
$bookAuthors = $stmt->fetchAll();
$bookAuthorIds = [];

$stmt = $pdo->query('SELECT * FROM authors');
$authors = $stmt->fetchAll();

$stmt = $pdo->query("SELECT DISTINCT language FROM books ORDER BY language ASC");
$languages = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $pdo->query("SELECT DISTINCT type FROM books ORDER BY type ASC");
$types = $stmt->fetchAll(PDO::FETCH_COLUMN);

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
        <h1>Change book: <?= $book['title']; ?></h1>
        <div class="section">
            <form action="update.php" method="post">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= $book['title']; ?>">
                <button type="submit" name="action" value="save">Change title</button>
            </form>
        </div>
        <div class="section">
            <h3>Authors:</h3>
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
            <h3>Add author:</h3>
            <form action="./add-author.php" method="post">
                <input type="hidden" name="book_id" value="<?= $id; ?>">
                <select name="author_id" required>
                    <option value="">-- vali autor --</option>
                    <?php foreach ( $authors as $author ) {
                        if ( !in_array($author['id'], $bookAuthorIds) ) { ?>
                        <option value="<?= $author['id']; ?>"><?= $author['first_name']; ?> <?= $author['last_name']; ?></option>
                    <?php }} ?>
                </select>
                <button type="submit" name="action" value="add-author">Add author</button>
            </form>
        </div>
        <form method="post">
            <label for="price">Price: <input type="text" name="price" value="<?=round($book['price'] ?? 0 ,2);?>"></label>
            <label for="Language">Language:</label>
            <select name="language">
                <?php foreach ($languages as $lang): ?>
                    <option value="<?= htmlspecialchars($lang); ?>"
                        <?= ($book['language'] === $lang) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lang); ?>
                    </option>
                <?php endforeach; ?>
            </select>  
            <label for="Type">Type:</label>         
            <select name="type">
                <?php foreach ($types as $type): ?>
                    <option value="<?= htmlspecialchars($type); ?>"
                        <?= ($book['type'] === $type) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type); ?>
                    </option>
                <?php endforeach; ?>
            </select>          
            <div>
                <label for="image">Pildi URL:</label>
                <input type="text" name="cover_path" id="image" value="<?= htmlspecialchars($book['cover_path'] ?? ''); ?>">
            </div>
            <hr>
            <button type="submit" name="action" value="save">Save</button>
        </form>
        <div>
            <a href="book.php?id=<?= $book['id']; ?>"><button>Back to book details</button></a>
            <a href="index.php"><button>Back to book list</button></a>
        </div>
    </div>
</body>
</html>
