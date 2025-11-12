<?php

require_once ('connection.php');

$bookid = $_POST['id'];
$authorId = $_POST['author_id'];

if ( !$bookid || !isset ($_POST['action']) || $_POST['action'] != 'remove_author') {
    echo 'Vigane  URL!';
    exit();
};
$stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id = :book_id AND author_id = :author_id');
$stmt->execute([
    'book_id' => $bookid,
    'author_id' => $authorId
]); 
header("Location: ./book.php?id=($bookid)");
die();
?>
