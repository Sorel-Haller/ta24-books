<?php
require_once('./connection.php');

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, year = :year, genre = :genre, price = :price WHERE id = :id');
    $stmt->execute([
        'title' => $_POST['title'],
        'year' => $_POST['year'],
        'genre' => $_POST['genre'],
        'price' => $_POST['price'],
        'id' => $id
    ]);
    header('Location: book.php?id=' . $id);
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();
?>

<form method="post">
    Pealkiri: <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>"><br>
    Aasta: <input type="text" name="year" value="<?= htmlspecialchars($book['year']) ?>"><br>
    Žanr: <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>"><br>
    Hind: <input type="text" name="price" value="<?= htmlspecialchars($book['price']) ?>"><br>
    <button type="submit">Salvesta</button>
</form>
