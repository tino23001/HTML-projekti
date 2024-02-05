<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lohikärmes Kauppa</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined', sans-serif;
            font-size: 2em; /* Voit säätää fonttikokoa tarpeidesi mukaan */
        }
    </style>    
</head>
<?php include('config.php'); ?>
<body>


    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="index.html" class="home-logo">LOHIKÄRMES</a>
            <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
            <nav class="nav">
                <a href="index.html">ETUSIVU</a>
                <a href="Kauppa.php"><b>KAUPPA</b></a>
                <a href="Ohjeet.html">OHJEET</a>
                <a href="Yhteystiedot.html">YHTEYSTIEDOT</a>
            </nav>
        </div>
    </header>
    <store-page>
        <section class="kehys">
        <?php
        
            if (isset($_GET['tuote_id'])) {
                $tuote_id = $_GET['tuote_id'];

                // Haetaan tietokannasta yksittäisen tuotteen tiedot
                $sql = "SELECT * FROM `tuotteet_web-ohjelmointi` WHERE tuote_id = :tuote_id";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':tuote_id', $tuote_id, PDO::PARAM_INT);
                $statement->execute();
                $tuote = $statement->fetch(PDO::FETCH_ASSOC);

                // Tulosta tuotteen tiedot
                if ($tuote) {
                    echo "<div><img src='" . htmlspecialchars($tuote['kuva']) . "' alt='" . htmlspecialchars($tuote['nimi']) . "'></div>";
                    echo "<div><h2>" . htmlspecialchars($tuote['nimi']) . "</h2>";
                    echo "<p>" . number_format($tuote['hinta'], 2, ',', ' ') . " €</p>";
                    echo "<p>" . htmlspecialchars($tuote['kuvaus']) . " </p>";
                    echo "<button>Lisää ostoskoriin</button>";
                    echo "</div>";

                } else {
                    echo "Tuotetta ei löytynyt.";
                }
            } else {
                echo "Tuote_id-parametri puuttuu.";
            }
       
        ?>

        </section>
    </store-page>
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