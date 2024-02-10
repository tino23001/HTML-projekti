<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body class="body-etusivu">

    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
            <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
            <nav class="nav">
                <a href="admin.php"><b>ADMIN</b></a>
                <a href="kauppaedit.php">TUOTELISTA</a>
                <a href="lisaatuote.php">TUOTTEEN LISÄYS</a>
            </nav>
        </div>
    </header>

    <section>
        <div class="texti">
            <h1 class="otsikko_muotoilu">Adminsivu</h1>
            <a href="kauppaedit.php" class="btn-shop">Tuotelista</a><br>
            <a href="lisaatuote.php" class="btn-shop">Lisää tuote</a>
        </div>
        <div class="tyhja-tila"></div>
    </section>    

    <div class="footer-bottom-admin">
        © Lohikärmes 2024
    </div>

    <script>
      function toggleMenu() {
        var nav = document.querySelector('nav');
        var menuIcon = document.querySelector('.menu-icon');

        if (nav.style.display === 'block') {
            nav.style.display = 'none';
            menuIcon.setAttribute('aria-label', 'Avaa valikko');
        } else {
            nav.style.display = 'block';
            menuIcon.setAttribute('aria-label', 'Sulje valikko');
        }
      }
    </script>

</body>
</html>
