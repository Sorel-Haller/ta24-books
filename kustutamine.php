<?php
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = :id');
    $stmt->execute(['id' => $_POST['id']]);
}

header('Location: index.php');
exit();
