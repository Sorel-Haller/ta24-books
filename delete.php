<?php

require_once 'connection.php';

$id = $_POST['id'];

if ( !$id || !isset ($_POST['action']) || $_POST['action'] != 'delete') {
    echo 'Vigane  URL!';
    exit();
};

$stmt = $pdo->query('SELECT id, title FROM books WHERE  is_deleted = 0 ');
$stmt->execute(['book_id' => $id]); 

while ($row = $stmt->fetch()) {
    $stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id = :book_id');
    $stmt->execute(['book_id' => $id]);
}