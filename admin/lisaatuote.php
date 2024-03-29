<?php
session_start();
include('config.php');

$message = ''; // Alustetaan viesti tyhjänä

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = htmlspecialchars($_POST['product_name']);
    $productPrice = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $productDescription = htmlspecialchars($_POST['product_description']);

    // Tarkistetaan tuotenimen olemassaolo
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tuotteet WHERE nimi = ?");
    $stmt->execute([$productName]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['message'] = "Tuote nimellä '{$productName}' on jo olemassa. Valitse toinen nimi.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (!preg_match('/^[a-zA-Z0-9\sÄÖäö]+$/', $productName) || strlen($productName) > 30) {
        $_SESSION['message'] = "Virhe! Tarkista tuotteen nimi. Nimen pituus ei saa ylittää 30 merkkiä ja sen tulee sisältää vain kirjaimia ja numeroita.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif ($productPrice <= 0 || !is_numeric($productPrice)) {
        $_SESSION['message'] = "Virhe! Hinnan tulee olla positiivinen numero.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (!preg_match('/^[a-zA-Z0-9\sÄÖäö.,!]{1,500}+$/', $productDescription)) {
        $_SESSION['message'] = "Virhe! Tarkista tuotteen kuvaus. Kuvauksen pituus ei saa ylittää 500 merkkiä ja se saa sisältää vain kirjaimia ja numeroita. Sallitut merkit ovat '.,!'";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Tiedoston MIME-tyypin tarkistus
    $fileMimeType = mime_content_type($_FILES["product_image"]["tmp_name"]);
    if (!in_array($fileMimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
        $_SESSION['message'] = "Vain JPG, JPEG, PNG & GIF -tiedostot ovat sallittuja.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Tiedostonimen puhdistaminen ennen tallentamista
    $originalFileName = $_FILES["product_image"]["name"];
    $cleanedFileName = preg_replace("/[^a-zA-Z0-9._-]/", "", $originalFileName);

    // Generoi yksilöllinen tiedostonimi
    $uniqueImageName = uniqid() . "-" . $cleanedFileName;
    
    // Tiedoston latauslogiikka
    $targetDir = "../uploads";
    $targetFile = $targetDir . DIRECTORY_SEPARATOR . $uniqueImageName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5000000; // 5MB
    $imageSize = $_FILES["product_image"]["size"];

    if (!in_array($imageFileType, $allowedFileTypes) || $imageSize > $maxFileSize) {
        $_SESSION['message'] = "Vain JPG, JPEG, PNG & GIF -tiedostot ovat sallittuja ja kuvan maksimikoko on 5MB.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
        try {
            $sql = "INSERT INTO tuotteet (nimi, hinta, kuva, kuvaus) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$productName, $productPrice, $uniqueImageName, $productDescription]);
            $_SESSION['message'] = "Tuote lisätty onnistuneesti.";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            $_SESSION['message'] = "Tietokantavirhe: " . $e->getMessage();
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        $_SESSION['message'] = "Virhe ladattaessa kuvaa.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>


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

<div class="grid-container">
    <div class="content">

            <header class="site-header">
                <div class="site-header__wrapper">
                    <a href="admin.html" class="home-logo">LOHIKÄRMES</a>
                    <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
                    <nav class="nav">
                        <a href="admin.html">ADMIN</a>
                        <a href="kauppaedit.php">TUOTELISTA</a>
                        <a href="lisaatuote.php"><b>TUOTTEEN LISÄYS</b></a>
                    </nav>
                </div>
            </header>
    </div>

    <div class="contact-container">

        <section class="contact-form">
        <?php
        // Tarkistetaan, onko istunnossa viestiä ja näytetään se
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            // Tämä osio näyttää viestin HTML-sivulla
            echo "<div class='message'>$message</div>";
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

            <div class="footer-bottom-admin">
                © Lohikärmes 2024
            </div>
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
