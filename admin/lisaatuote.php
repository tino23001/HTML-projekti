<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisää tuote</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body>

    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
        </div>
    </header>

    <div class="contact-container">
        <section class="contact-form">
            <?php
            $message = ''; // Alustetaan viesti tyhjänä
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include('config.php');
                $productName = htmlspecialchars($_POST['product_name']);
                $productPrice = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $productDescription = htmlspecialchars($_POST['product_description']);

                // Tarkistetaan tuotenimen olemassaolo
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM tuotteet WHERE nimi = ?");
                $stmt->execute([$productName]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    $message = "Tuote nimellä '{$productName}' on jo olemassa. Valitse toinen nimi.";
                } elseif (!preg_match('/[a-zA-Z0-9]/', $productName) || strlen($productName) > 30) {
                    $message = "Virhe! Tarkista tuotteen nimi. Nimen pituus ei saa ylittää 30 merkkiä ja sen tulee sisältää vain kirjaimia ja numeroita.";
                } elseif ($productPrice <= 0 || !is_numeric($productPrice)) {
                    $message = "Virhe! Hinnan tulee olla positiivinen numero.";
                } else {
                    // Kuvan käsittelyn ehdot
                    $targetDir = "../uploads"; 
                    $uniqueImageName = uniqid() . basename($_FILES["product_image"]["name"]);
                    $targetFile = $targetDir . DIRECTORY_SEPARATOR . $uniqueImageName;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
                    $maxFileSize = 5000000; // 5MB
                    $imageSize = $_FILES["product_image"]["size"];

                    if (!in_array($imageFileType, $allowedFileTypes) || $imageSize > $maxFileSize) {
                        $message = "Vain JPG, JPEG, PNG & GIF -tiedostot ovat sallittuja ja kuvan maksimikoko on 5MB.";
                    } elseif (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                        try {
                            $sql = "INSERT INTO tuotteet (nimi, hinta, kuva, kuvaus) VALUES (?, ?, ?, ?)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$productName, $productPrice, $uniqueImageName, $productDescription]);
                            $message = "Tuote lisätty onnistuneesti.";
                        } catch (PDOException $e) {
                            $message = "Tietokantavirhe: " . $e->getMessage();
                        }
                    } else {
                        $message = "Virhe ladattaessa kuvaa.";
                    }
                }
            }
            if (!empty($message)) {
                echo "<p>$message</p>";
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                <h1>Lisää tuote</h1>
                <input type="text" name="product_name" placeholder="Tuotteen nimi" required>
                <input type="number" name="product_price" placeholder="Hinta" step="0.01" required>
                <textarea name="product_description" placeholder="Tuotteen kuvaus" required></textarea>
                <input type="file" name="product_image" required>
                <button type="submit">Tallenna tuote</button>
            </form>
        </section>
    </div>
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

</body>
</html>

