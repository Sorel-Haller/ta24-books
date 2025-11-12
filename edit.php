<?php
require_once('./connection.php');

// Check if a book ID is provided
if (!isset($_GET['id']) || !$_GET['id']) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$id = $_GET['id'];

// Fetch book details
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch(); 

$stmt = $pdo->prepare('SELECT first_name, last_name 
                       FROM book_auhtors ba
                       LEFT JOIN authors a ON  ba.author_id
                       WHERE ba.book_id = :book_id');
$stmt->execute(['book_id' => $id]);
$authors = $stmt->fetchAll();

if (!$book) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?></title>
</head>
<body>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="text" name="title" value="<?= $book['title'] ?>" >
        <br>
        <button type="submit" name="action" value="save"> Salvesta</button>
    </form>
</body>
</html>
