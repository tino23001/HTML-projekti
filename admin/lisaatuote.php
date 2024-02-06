<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
</head>
<body>
<?php
// Sisällytä tietokantayhteyden määrittelyt
include('config.php');

// Tarkistetaan onko lomake lähetetty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitaatioesimerkki
    $productName = htmlspecialchars($_POST['product_name']);
    $productPrice = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $productDescription = htmlspecialchars($_POST['product_description']);

    // Kuvan käsittely
    $targetDir = "../uploads";  //tänne kun sais tallennettua --> $targetDir = "lohikarmes/"; 
    $uniqueImageName = uniqid() . basename($_FILES["product_image"]["name"]); // Luo uniikki tiedostonimi
    $targetFile = $targetDir . DIRECTORY_SEPARATOR . $uniqueImageName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Tarkista onko tiedostotyyppi sallittu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Vain JPG, JPEG, PNG & GIF tiedostot ovat sallittuja.";
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
            // Tässä kohtaa tiedosto on siirretty onnistuneesti
            // Lisää tuotteen tiedot tietokantaan
            try {
                $sql = "INSERT INTO tuotteet (nimi, hinta, kuva, kuvaus) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$productName, $productPrice, $uniqueImageName, $productDescription]); //$targetFile oli $uniqueImageName tilalla

                echo "Tuote lisätty onnistuneesti.";
            } catch (PDOException $e) {
                echo "Tietokantavirhe: " . $e->getMessage();
            }
        } else {
            echo "Virhe ladattaessa kuvaa.";
        }
    }
}
?>
</body>
</html>




