<?php
var_dump($_GET); 

if (isset($_POST["action-submit"]) && isset($_POST['username']) ) {
    $user = $_POST["username"];
}

$names = ['Tiit', 'Kati', 'Juku', 'Mari', 'Peeter'];

foreach ($names as $key => $name) {
    echo ($key + 1) . ". {$name}<br>";
}

for ($i = 0; $i < count($names); $i++) {
    echo ($i + 1) . ". {$names[$i]} <br>";
}

$i = 0;
while ($i < count($names)) {
    echo ($i + 1) . ". {$names[$i]} <br>";
    $i++;
}

$i = 0;
do {
    echo ($i + 1) . ". {$names[$i]} <br>";
    $i++;
} while ($i < count($names) );

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