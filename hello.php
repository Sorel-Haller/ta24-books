<?php
var_dump($_GET); 
// kommentaar
/* blokkommentaar */

if (!isset($_GET["action-submit"]) && isset($_GET["username"]) ) {
    $user = $_GET["username"];
}
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
    
    <?php if ( !isset($user) ) {?>
        Hello, <?= $user; ?>!
    <?php } ?>
    
</body>
</html>