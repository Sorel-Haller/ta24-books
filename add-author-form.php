<?php
require_once('./connection.php');

if (isset($_POST['action-submit'])) {

    $first = trim($_POST['first-name']);
    $last  = trim($_POST['last-name']);

    if ($first === '' || $last === '') {
        echo "Viga: eesnimi ja perekonnanimi peavad olema täidetud!";
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:first, :last)');
    $stmt->execute([
        'first' => $first,
        'last'  => $last
    ]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lisa uus autor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            height: 40px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        a button {
            background-color: #f44336;
            margin-top: 10px;
        }

        a button:hover {
            background-color: #d7372f;
        }

        a {
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Lisa uus autor</h1>

    <form action="" method="post">

        <label for="first-name">Eesnimi:</label>
        <input type="text" id="first-name" name="first-name" required>

        <label for="last-name">Perekonnanimi:</label>
        <input type="text" id="last-name" name="last-name" required>

        <button type="submit" name="action-submit">Lisa autor</button>
    </form>

    <a href="index.php">
        <button>Tagasi</button>
    </a>

</body>
</html>
