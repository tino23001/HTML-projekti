<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lohikärmes Etusivu</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>


<body class="body-etusivu">
    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="index.php" class="home-logo">LOHIKÄRMES</a>
            <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
            <nav class="nav">
                <a href="index.php"><b>ETUSIVU</b></a>
                <a href="Kauppa.php">KAUPPA</a>
                <a href="Ohjeet.html">OHJEET</a>
                <a href="Yhteystiedot.html">YHTEYSTIEDOT</a>
            </nav>
        </div>
    </header>

    <section>
        <div class="texti">
                <h1 class="otsikko_muotoilu">LOREM IPSUM</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam et imperdiet odio. Vivamus est nisl, consequat sed dui vitae, elementum commodo erat.</p>
        </div>
        <!-- Tyhjää tilaa lisäämällä nostetaan footer alaspäin -->
        <div class="tyhja-tila"></div>
    </section>    

    <section>        
    <h2 class="top-products-title">KUUKAUDEN SUOSITUIMMAT</h2>
    
    <div class="top-products">
        <?php
         include('config.php');
        // Hae tuotteet, joiden tuote_id ovat 1, 5 ja 6
        $sql = "SELECT tuote_id, nimi, hinta, kuva FROM tuotteet WHERE tuote_id IN (1, 5, 6)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $tuotteet = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tuotteet as $tuote) {
            echo "<div class='top-product-item'>";
            echo "<img src='uploads/" . htmlspecialchars($tuote['kuva']) . "' alt='" . htmlspecialchars($tuote['nimi']) . "'>";
            echo "<h3>" . htmlspecialchars($tuote['nimi']) . "</h3>";
            echo "<p>€" . number_format($tuote['hinta'], 2, ',', ' ') . "</p>";
            echo "<a href='Tuote.php?tuote_id=" . $tuote['tuote_id'] . "' class='btn-shop'>Tarkastele</a>";
            echo "</div>";
        }
        ?>
    </div>
</section>

    

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Asiakaspalvelu</h4>
               
                <p><strong>Puhelin:</strong> <a href="tel:+358201234567">+358 20 123 4567</a></p>
                <a href="Yhteystiedot.html">Yhteydenottolomake</a>
            </div>
            <div class="footer-section">
                <h4>Info</h4>
                <a href="#palautukset">Palautukset</a>
                <a href="#takuu">Takuu</a>
                <a href="#maksutavat">Maksutavat</a>
                <a href="#toimitustavat">Toimitustavat</a>
            </div>
            <div class="footer-section">
                <h4>Resurssit</h4>
                <a href="#vinkit-ja-osto-oppaat">Vinkit ja osto-oppaat</a>
                <a href="#vari-ja-luonneanalyysi">Väri- ja luonneanalyysi</a>
                <a href="#koulutusopas">Koulutusopas</a>
            </div>
            <div class="footer-section">
                <h4>Palvelut</h4>
                <a href="#yritysmyynti">Yritysmyynti</a>
                <a href="#neuvontapalvelut">Neuvontapalvelut</a>
                <a href="#elainlaakaripalvelut">Eläinlääkäripalvelut</a>
            </div>
            <div class="footer-section">
                <h4>Sosiaalinen media</h4>
                <div class="social-media-links">
                    <a href="https://www.facebook.com" target="_blank">
                        <img src="fb.png" alt="Facebook" class="social-icon">
                        <span>Facebook</span>
                    </a>
                    <a href="https://www.instagram.com/yourpage" target="_blank">
                        <img src="ig.png" alt="Instagram" class="social-icon">
                        <span>Instagram</span>
                    </a>
                    <a href="https://www.linkedin.com/yourpage" target="_blank">
                        <img src="linkedin.png" alt="LinkedIn" class="social-icon">
                        <span>LinkedIn</span>
                    </a>
                    <a href="https://www.youtube.com/yourpage" target="_blank">
                        <img src="youtube.png" alt="YouTube" class="social-icon">
                        <span>YouTube</span>
                    </a>
                </div>
            </div>
            
        </div>
        <div class="footer-bottom">
            © Lohikärmes 2024
        </div>
    </footer>

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