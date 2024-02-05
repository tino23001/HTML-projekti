<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['kayttaja'])) {
            echo "Tervetuloa " . $_SESSION['kayttaja'] . "!<br>";
            echo "<a href='logout.php'>Kirjaudu ulos</a>";
        } else {
            echo "Et ole kirjautunut sisään!<br>";
            echo "<a href='login.php'>Kirjaudu sisään</a>";
        }
    ?>

<h1>Admin-sivu</h1>
</body>
</html>
