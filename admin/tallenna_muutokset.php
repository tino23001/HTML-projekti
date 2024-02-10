<?php 
include('config.php');

if(isset($_POST['tuote_id'], $_POST['product_name'])) {
    $tuote_id = $_POST['tuote_id'];
    $nimi = trim($_POST['product_name']);
    $hinta = trim($_POST['product_price']);
    $kuvaus = trim($_POST['product_description']);

    // Sanitaatio
    $nimi = htmlspecialchars($nimi);
    $hinta = filter_var($hinta, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $kuvaus = htmlspecialchars($kuvaus);

    // Tarkistetaan, onko samanniminen tuote jo olemassa tietokannassa
    $sql = "SELECT COUNT(*) FROM tuotteet WHERE nimi = ? AND tuote_id != ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nimi, $tuote_id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "Tuotenimi on jo käytössä. Valitse toinen nimi.";
        exit;
    }

    // Validointi
    if (!preg_match('/^[a-zA-Z0-9\sÄÖäö]{1,30}$/', $nimi) || !is_numeric($hinta) || $hinta <= 0 || strlen($kuvaus) > 500 || !preg_match('/^[a-zA-Z0-9\sÄÖäö.,!]{1,500}$/', $kuvaus)) {
        echo "Invalid input";
        exit;
    }



    // Jos tuote_id on uuden tuotteen lisäyksessä, muokkaa SQL-lauseet vastaavasti
    $sql = "UPDATE tuotteet SET nimi = ?, hinta = ?, kuvaus = ? WHERE tuote_id = ?";
    $statement = $pdo->prepare($sql);

    if ($statement->execute([$nimi, $hinta, $kuvaus, $tuote_id])) {
        echo "success";
    } else {
        echo "failure";
    }
} else {
    echo "Virhe: Tuote_id ei ole määritetty";
}

$pdo = null;
?>

