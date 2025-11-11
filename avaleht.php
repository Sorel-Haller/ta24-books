<?php
require_once('./connection.php');

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
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="add_author.php">Lisa autor</a>
</body>
</html>
