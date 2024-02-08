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

<div class="grid-container">
    <div class="content">

        <body class="body-etusivu">
            <header class="site-header">
                <div class="site-header__wrapper">
                    <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
                    <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
                    <nav class="nav">
                        <a href="admin.php"><b>ADMIN</b></a>
                        <a href="kauppaedit.php">TUOTELISTA</a>
                        <a href="lisaatuote.html">TUOTTEEN LISÄYS</a>
                    </nav>
                </div>
            </header>

<section>
        <div class="texti">
                <h1 class="otsikko_muotoilu">Adminsivu</h1>
                <p><a href="kauppaedit.php">Tuotelista</a><br></p>
                <p><a href="lisaatuote.html">Lisää tuote</a><br></p>
        </div>
        <!-- Tyhjää tilaa lisäämällä nostetaan footer alaspäin -->
        <div class="tyhja-tila"></div>
</section>    

    </div>
    <div class="footer-bottom-admin">
        © Lohikärmes 2024
    </footer>
    </div>

</body>
</html>
