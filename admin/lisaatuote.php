<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body>

<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = htmlspecialchars($_POST['product_name']);
    $productPrice = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $productDescription = htmlspecialchars($_POST['product_description']);

    // Tarkistetaan, löytyykö tuotenimi jo tietokannasta
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tuotteet WHERE nimi = ?");
    $stmt->execute([$productName]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Tuotenimi löytyy jo, ei voi lisätä
        echo "Tuote nimellä '{$productName}' on jo olemassa. Valitse toinen nimi.";
        return; // Keskeytetään suoritus tähän, jos tuotenimi on jo käytössä
    }

    // Tarkistetaan, onko tuotenimi sopivan pituinen
    if (strlen($productName) > 30) {
        echo "Virhe! Tuotenimen pituus ei saa ylittää 30 merkkiä.";
        return;
    }

    // Tarkistetaan, että hinta on positiivinen
    if ($productPrice <= 0) {
        echo "Virhe! Hinnan tulee olla positiivinen numero.";
        return;
    }

    // Kuvan käsittely
    $targetDir = "../uploads"; 
    $uniqueImageName = uniqid() . basename($_FILES["product_image"]["name"]);
    $targetFile = $targetDir . DIRECTORY_SEPARATOR . $uniqueImageName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Tarkista onko tiedostotyyppi sallittu ja kuvan koko oikea
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5000000; // esim. 5MB
    $imageSize = $_FILES["product_image"]["size"];

    if (!in_array($imageFileType, $allowedFileTypes) || $imageSize > $maxFileSize) {
        echo "Vain JPG, JPEG, PNG & GIF -tiedostot ovat sallittuja ja kuvan maksimikoko on 5MB.";
        return;
    }

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
        // Lisää tuotteen tiedot tietokantaan
        try {
            $sql = "INSERT INTO tuotteet (nimi, hinta, kuva, kuvaus) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$productName, $productPrice, $uniqueImageName, $productDescription]);

            echo "Tuote lisätty onnistuneesti.";
        } catch (PDOException $e) {
            echo "Tietokantavirhe: " . $e->getMessage();
        }
    } else {
        echo "Virhe ladattaessa kuvaa.";
    }
}
?>
</body>
</html>

