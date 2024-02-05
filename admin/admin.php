<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="lohikarmes/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        session_start();
    ?>

<h1>Admin-sivu</h1>

    <div class="container">
        <div class="box">
            <p>Tervetuloa <?php echo $_SESSION['kayttaja']; ?>!</p>
            <a href="indexedit.php">Etusivun muokkaustila</a><br><br>
            <a href="Kauppaedit.php">Kauppasivun muokkaustila</a><br><br>
            <a href="Ohjeetedit.php">Ohjesivun muokkaustila</a><br><br>
            <a href="Yhteystiedotedit.php">Yhteystietosivun muokkaustila</a><br><br>
        </div>
    </div>

</body>
</html>
