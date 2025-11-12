<?php
require_once('./connection.php');

// Check if a book ID is provided
if (!isset($_GET['id']) || !$_GET['id']) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$id = (int)$_GET['id'];

// ------------------------
// Handle author deletion
// ------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_author'])) {
    $delete_author_id = (int)$_POST['delete_author'];

    // Remove the link between the book and the author
    $stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id = :book_id AND author_id = :author_id');
    $stmt->execute([
        'book_id' => $id,
        'author_id' => $delete_author_id
    ]);

    // Optional: delete the author if they have no other books
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM book_authors WHERE author_id = :author_id');
    $stmt->execute(['author_id' => $delete_author_id]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare('DELETE FROM authors WHERE id = :id');
        $stmt->execute(['id' => $delete_author_id]);
    }

    header("Location: book.php?id=$id");
    exit();
}

// ------------------------
// Handle adding a new author
// ------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_author'])) {
    if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
        // Add author
        $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:first_name, :last_name)');
        $stmt->execute([
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name']
        ]);

        // Link author to book
        $author_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
        $stmt->execute([
            'book_id' => $id,
            'author_id' => $author_id
        ]);

        echo "<p>Autor lisatud!</p>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_book'])) {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, release_date = :release_date, type = :type, price = :price WHERE id = :id');
    $stmt->execute([
        'title' => $_POST['title'],
        'release_date' => $_POST['release_date'],
        'type' => $_POST['type'],
        'price' => $_POST['price'],
        'id' => $id
    ]);

    // Optional: show a success message
    echo "<p>Raamat uuendatud!</p>";

    // Refresh page to show updated info
    header("Location: book.php?id=$id");
    exit();
}
// ------------------------
// Fetch book info
// ------------------------
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

// ------------------------
// Fetch authors for this book
// ------------------------
$stmt = $pdo->prepare('
    SELECT a.id, a.first_name, a.last_name
    FROM book_authors ba
    LEFT JOIN authors a ON ba.author_id = a.id
    WHERE ba.book_id = :book_id
');
$stmt->execute(['book_id' => $id]);
$authors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($book['title']) ?></h1>

    <!-- Book Info (Read-only) -->
    <h2>Raamatu info</h2>
    <p>Pealkiri: <?= htmlspecialchars($book['title']) ?></p>
    <p>Aasta: <?= htmlspecialchars($book['release_date']) ?></p>
    <p>Tüüp: <?= htmlspecialchars($book['type']) ?></p>
    <p>Hind: <?= htmlspecialchars($book['price']) ?></p>
    <?php if (!empty($book['cover_path'])): ?>
        <p>Pilt:</p>
        <img src="<?= htmlspecialchars($book['cover_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" style="max-width:200px; height:auto;">
    <?php else: ?>
        <p>Puudub pilt</p>
    <?php endif; ?>

    <!-- Authors List -->
    <h2>Autorid</h2>
    <ul>
        <?php foreach ($authors as $author): ?>
            <li>
                <?= htmlspecialchars($author['first_name'] . ' ' . $author['last_name']) ?>
                
                <!-- Delete Author Form -->
                <form method="post" style="display:inline;" onsubmit="return confirm('Oled kindel, et tahad kustutada?');">
                    <input type="hidden" name="delete_author" value="<?= $author['id'] ?>">
                    <button type="submit">Kustuta</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="./edit.php?id"<?php $id; ?> >Muuda</a>
    <br>
    <!-- Delete Book Form -->
    <form action="./delete.php" method="POST" >
            <input type="hidden" name="id" value="<?= $id; ?>">
            <button type="submit" name="action" value="delete" onclick="return confirm('Oled kindel, et tahad kustutada?');">Kustuta raamat</button>   
    </form>

    
    <a href="index.php">    
        <button >Tagasi</button>
    </a>
</body>
</html>
