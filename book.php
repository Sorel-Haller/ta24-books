<?php
require_once('./connection.php');

if (!isset($_GET['id']) || !$_GET['id']) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT first_name, last_name FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE book_id= :book_id');
$stmt->execute(['book_id' => $id]);
$authors = $stmt->fetchAll();


var_dump($authors);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?></title>
<body>
    <h1><?= htmlspecialchars($book['title']) ?></h1>
    <h3><?= htmlspecialchars($authors['name']) ?></h3>
    
    Autorid:
    <ul>
        <?php foreach ($authors as $author) { ?>
            <li><?= htmlspecialchars($author['first_name'] . ' ' . $author['last_name']) ?></li>
            <li><?= "{$author['first_name']} {$author['last_name']}" ?></li>
        <?php } ?>

    </ul>
</body>
</html>
