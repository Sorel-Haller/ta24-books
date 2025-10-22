<?php
var_dump($_GET); 
// kommentaar
/* blokkommentaar */

if (isset($_POST["action-submit"]) && isset($_POST['username']) ) {
    $user = $_POST["username"];
}
?>

<!doctype html>
<html>
<head>
    <title>Hello Page</title>                  
    <meta charset="utf-8">
</head>
<body>  
    <form action="./hello.php" method="POST">

        <label for="user">Nimi:</label>
        <input type="text" name="username" id="user">
        <input type="submit" name="action-submit" value="Saada">
    </form>
    
    <?php if ( isset($user) ) {?>

        Hello, <?= $user; ?>!
        
    <?php } ?>
    
</body>
</html>