<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php
include('config.php');

// Otetaan vastaan tuote_id, jonka perusteella poistetaan tuote tietokannasta
if(isset($_POST['tuote_id'])) {
    try {
        // Poistetaan tuote tietokannasta
        $tuote_id = $_POST['tuote_id'];
        $sql = "DELETE FROM tuotteet WHERE tuote_id = :tuote_id";
        $statement = $pdo->prepare($sql);
        $statement->execute([':tuote_id' => $tuote_id]);

        // Palautetaan vastaus, joka kertoo, että poisto onnistui
        echo "success";

        // Lisää lokituloste onnistuneesta poistosta
        error_log("Tuote poistettu onnistuneesti. Tuote ID: $tuote_id");

    } catch (PDOException $e) {
        // Virheenkäsittely: Palautetaan virheilmoitus, jos poistaminen epäonnistui
        echo "Virhe: " . $e->getMessage();

        // Lisää lokituloste virheestä
        error_log("Virhe poistettaessa tuotetta. Virhe: " . $e->getMessage());
    }
} else {
    // Palautetaan virheilmoitus, jos tuote_id:tä ei ole määritetty
    echo "Virhe: Tuote_id ei ole määritetty";

    // Lisää lokituloste tuote_id:n puuttumisesta
    error_log("Virhe poistettaessa tuotetta: Tuote_id ei ole määritetty");
}
?>



</body>
</html>




