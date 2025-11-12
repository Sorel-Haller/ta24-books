<?php
require_once('./connection.php');

// Handle deletion if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = :id');
    $stmt->execute(['id' => $_POST['delete_id']]);
    // Redirect to avoid form resubmission
    header('Location: index.php');
    exit();
}

// Handle search
$search = $_GET['q'] ?? '';
$sql = "SELECT * FROM books WHERE is_deleted = 0";
$params = [];

if (!empty($search)) {
    $sql .= " AND title LIKE :search";
    $params['search'] = "%$search%";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Raamatupood</title>
</head>
<body>
    <h1>Raamatud</h1>

    <form method="get">
        <input type="text" name="q" placeholder="Otsi raamatut..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Otsi</button>
    </form>

    <ul>
        <?php foreach ($books as $book): ?>
            <li>
                <a href="book.php?id=<?= $book['id'] ?>">
                    <?= htmlspecialchars($book['title']) ?>
                </a>
                
                <!-- Delete form -->
                <form method="post" style="display:inline;" onsubmit="return confirm('Oled kindel, et tahad kustutada?');">
                    <input type="hidden" name="delete_id" value="<?= $book['id'] ?>">
                    <button type="submit">Kustuta</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="add_author.php">Lisa autor</a>
</body>
</html>
