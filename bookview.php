<?php
require_once('./connection.php');

if (!isset($_GET['id']) || !$_GET['id']) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$id = (int)$_GET['id'];

// Võta raamat andmebaasist
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id AND is_deleted = 0');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

if (!$book) {
    echo 'Raamatut ei leitud!';
    exit();
}

// Võta autorid
$stmt = $pdo->prepare('
    SELECT a.first_name, a.last_name 
    FROM book_authors ba 
    LEFT JOIN authors a ON ba.author_id = a.id 
    WHERE ba.book_id = :book_id
');
$stmt->execute(['book_id' => $id]);
$authors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($book['title']) ?></h1>
    <p><strong>Kirjeldus:</strong> <?= htmlspecialchars($book['description']) ?></p>
    <p><strong>Aasta:</strong> <?= htmlspecialchars($book['year']) ?></p>
    <p><strong>Žanr:</strong> <?= htmlspecialchars($book['genre']) ?></p>
    <p><strong>Hind:</strong> <?= htmlspecialchars($book['price']) ?> €</p>
    <p><strong>Kirjastus:</strong> <?= htmlspecialchars($book['publisher']) ?></p>
    <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Pilt" width="150">

    <h3>Autorid:</h3>
    <ul>
        <?php foreach ($authors as $author): ?>
            <li><?= htmlspecialchars($author['first_name'] . ' ' . $author['last_name']) ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="edit_book.php?id=<?= $book['id'] ?>">Muuda</a>

    <form method="post" action="delete_book.php" style="margin-top:10px;">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <button type="submit">Kustuta</button>
    </form>

    <p><a href="index.php">← Tagasi nimekirja</a></p>
</body>
</html>
