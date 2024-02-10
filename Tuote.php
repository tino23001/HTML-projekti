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
        
         .hidden {
            display: none;
        }
    </style>    
</head>
<?php include('config.php'); ?>
<body>


    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="index.php" class="home-logo">LOHIKÄRMES</a>
            <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
            <nav class="nav">
                <a href="index.php">ETUSIVU</a>
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
                $sql = "SELECT * FROM tuotteet WHERE tuote_id = :tuote_id";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':tuote_id', $tuote_id, PDO::PARAM_INT);
                $statement->execute();
                $tuote = $statement->fetch(PDO::FETCH_ASSOC);

                $stmt = $pdo->prepare('SELECT AVG(arvostelu) AS overall_rating, COUNT(*) AS total_reviews FROM arvostelut WHERE tuote_id = ?');
                $stmt->execute([$tuote_id]);
                $reviews_info = $stmt->fetch(PDO::FETCH_ASSOC);
            

                // Tulosta tuotteen tiedot
                if ($tuote) {
                    // Käytä 'product-image' ja 'product-details' luokkia asettelun hallintaan
                echo "<div class='product-image'><img src='uploads/" . htmlspecialchars($tuote['kuva']) . "' alt='" . htmlspecialchars($tuote['nimi']) . "'></div>";
                echo "<div class='product-details'>";
                echo "<h2>" . htmlspecialchars($tuote['nimi']) . "</h2>";
                echo "<span class='num'>" . number_format($reviews_info['overall_rating'], 1) . "</span>&nbsp;"; // Numeerinen keskiarvo, välilyönti lisätty
                $stars = str_repeat('&#9733;', round($reviews_info['overall_rating'])) . str_repeat('&#9734;', 5 - round($reviews_info['overall_rating']));
                echo "<span class='stars'>" . $stars . "</span> ";
                echo "<span class='total'>" . $reviews_info['total_reviews'] . " reviews</span>";
                echo "<p>" . number_format($tuote['hinta'], 2, ',', ' ') . " €</p>";
                echo "<p>" . htmlspecialchars($tuote['kuvaus']) . "</p>";
                echo "<button>Lisää ostoskoriin</button>";
                echo "</div>";
    

                } else {
                    echo "Tuotetta ei löytynyt.";
                }
            } else {
                echo "Tuote_id-parametri puuttuu.";
            }
       
            ?>
            <div class="reviews_section">
            <?php
        
            // Funktio ajan näyttämiseen "X aikaa sitten" -muodossa
            function time_elapsed_string($datetime, $full = false) {
                $now = new DateTime;
                $ago = new DateTime($datetime);
                $diff = $now->diff($ago);
    
            // Laske viikot ja vähennä ne päivien määrästä
                $w = floor($diff->d / 7);
            $diff->d -= $w * 7;

            $string = [
                'y' => 'year', 'm' => 'month', 'd' => 'day',
                'h' => 'hour', 'i' => 'minute', 's' => 'second',
            ];
            // Lisää viikot erikseen, koska DateInterval ei sisällä viikkoja
            if ($w > 0) {
            $string['w'] = $w . ' week' . ($w > 1 ? 's' : '');
            }

            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                unset($string[$k]);
            }
            }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
            }



            session_start(); 

        // Arvostelun käsittely
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['tuote_id'])) {
                // Sanitaatio
                $kayttajanimi = htmlspecialchars($_POST['kayttajanimi']);
                $kommentti = htmlspecialchars($_POST['kommentti']);
                $arvostelu = filter_var($_POST['arvostelu'], FILTER_SANITIZE_NUMBER_INT);

                // Validaatio
                if (!empty($kayttajanimi) && !empty($kommentti) && filter_var($arvostelu, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 5]])) {
                    // Jos syötteet ovat kelvollisia, jatketaan käsittelyä
                    $stmt = $pdo->prepare('INSERT INTO arvostelut (tuote_id, kayttajanimi, kommentti, arvostelu, paivamaara) VALUES (?,?,?,?,NOW())');
                    $stmt->execute([$_GET['tuote_id'], $kayttajanimi, $kommentti, $arvostelu]);

                    // Aseta sessiomuuttuja ilmoitusta varten
                    $_SESSION['arvostelu_lahetetty'] = true;

                    // Ohjaa käyttäjä samaan sivuun, mutta GET-metodilla
                    header('Location: Tuote.php?tuote_id=' . $_GET['tuote_id']);
                    exit;
                } else {
                    // Aseta virheviesti, jos validaatio epäonnistuu
                 echo 'Tarkista, että kaikki kentät on täytetty oikein ja arvostelu on välillä 1-5.';
                
             }
            }

            // Sivun alkuun
            if (isset($_SESSION['arvostelu_lahetetty'])) {
                echo 'Arvostelusi on lähetetty!';
                unset($_SESSION['arvostelu_lahetetty']); // Poista ilmoitus näytön jälkeen
            }

            if (isset($_GET['tuote_id'])) {
                // Haetaan kaikki arvostelut
                $stmt = $pdo->prepare('SELECT * FROM arvostelut WHERE tuote_id = ? ORDER BY paivamaara DESC');
                $stmt->execute([$_GET['tuote_id']]);
                $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Haetaan keskiarvo ja arvostelujen määrä
                $stmt = $pdo->prepare('SELECT AVG(arvostelu) AS overall_rating, COUNT(*) AS total_reviews FROM arvostelut WHERE tuote_id = ?');
                $stmt->execute([$_GET['tuote_id']]);
                    $reviews_info = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                exit('Please provide the product ID.');
            }       
            ?>



            <div class="write_review_btn"><h3>Kirjoita arvostelu </h3></div>
            <div class="write_review">
                <form method="post">
                    <input name="kayttajanimi" type="text" placeholder="Nimimerkki" required>
                    <input name="arvostelu" type="number" min="1" max="5" placeholder="Arvostelu (1-5)" required>
                    <textarea name="kommentti" placeholder="Kommentti" required></textarea>
                    <button type="submit">Lähetä</button>
                </form>
            </div>
            <div class="reviews-container">
            <div class="button-container">
            <!-- Lisää nappi arvosteluiden näyttämiseen -->
                <button id="toggleReviewsBtn" onclick="toggleReviews()">Näytä arvostelut</button>
            <!-- Arvosteluiden konteineri, joka on oletuksena piilotettu -->
            </div>
            <div id="reviews" class="hidden">
            <?php foreach ($reviews as $review): ?>
            <div class="review">
                <h3 class="name"><?php echo htmlspecialchars($review['kayttajanimi'], ENT_QUOTES); ?></h3>
                <div>
                    <span class="rating"><?php echo str_repeat('&#9733;', $review['arvostelu']); ?></span>
                    <span class="date"><?php echo time_elapsed_string($review['paivamaara']); ?></span>
                </div>
                <p class="content"><?php echo htmlspecialchars($review['kommentti'], ENT_QUOTES); ?></p>
              </div>
             <?php endforeach; ?>
            </div>
        </div>
            </section>
            </store-page>

                <script>
            function toggleReviews() {
                var reviews = document.getElementById("reviews");
                var button = document.getElementById("toggleReviewsBtn"); // Aseta napille ID

                if (reviews.classList.contains("hidden")) {
                    reviews.classList.remove("hidden");
                    button.textContent = "Piilota arvostelut"; // Muuta napin teksti "Piilota arvostelut" -tekstiksi
                } else {
                    reviews.classList.add("hidden");
                    button.textContent = "Näytä arvostelut"; // Muuta napin teksti takaisin "Näytä arvostelut" -tekstiksi
                }
            }
                </script>

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