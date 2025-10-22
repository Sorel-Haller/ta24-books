<?php

var_dump($_GET);
//kommentaar /*blok*/
$user = $GET["user"];

echo "Hello, {$username}!<br>";
echo "Hello, World!\n";
?>

<!doctype html>
<html>
<head>
    <title>Hello Page</title>                  
    <meta charset="utf-8">
</head>
<body>  
    <form action="./hello.php" method="get">

        <label for="user">Nimi:</label>
        <input type="text" name="username" id="user">
        <input type="submit" name="action-submit" value="Saada">
    </form>
</body>
</html>