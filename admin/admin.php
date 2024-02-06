<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body>

    <?php
        session_start();
    ?>

<header class="site-header">
        <div class="site-header__wrapper">
            <a href="index.php" class="home-logo">LOHIKÄRMES</a>
        </div>
</header>

<section>
        <div class="texti">
                <h1 class="otsikko_muotoilu">Adminsivu</h1>
                <p><a href="kauppaedit.php">Muokkaa kauppasivua</a><br></p>
                <p><a href="lisaatuote.html">Lisää tuote kauppasivulle</a></p>
        </div>
        <!-- Tyhjää tilaa lisäämällä nostetaan footer alaspäin -->
        <div class="tyhja-tila"></div>
</section>    

    <div class="footer-bottom">
            © Lohikärmes 2024
    </div>

</body>
</html>
