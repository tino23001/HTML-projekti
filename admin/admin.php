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
<header class="site-header">
        <div class="site-header__wrapper">
            <a href="index.html" class="home-logo">LOHIKÄRMES</a>
        </div>
</header>

<section>
        <div class="texti">
                <h1 class="otsikko_muotoilu">Adminsivu</h1><br><br>
                <p><a href="kauppaedit.php">Muokkaa kauppasivua</p>
        </div>
        <!-- Tyhjää tilaa lisäämällä nostetaan footer alaspäin -->
        <div class="tyhja-tila"></div>
</section>    

    <?php
        session_start();
    ?>

<h1>Admin-sivu</h1>

    <div class="container">
        <div class="box">
            <p>Tervetuloa <?php echo $_SESSION['kayttaja']; ?>!</p>
            <a href="Kauppaedit.php">Kauppasivun muokkaustila</a><br><br>
        </div>
    </div>

    <div class="footer-bottom">
            © Lohikärmes 2024
    </div>

</body>
</html>
