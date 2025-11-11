<?php
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:first_name, :last_name)');
    $stmt->execute([
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
    ]);
    echo "Autor lisatud!";
}
?>

<form method="post">
    Eesnimi: <input type="text" name="first_name"><br>
    Perenimi: <input type="text" name="last_name"><br>
    <button type="submit">Lisa autor</button>
</form>
