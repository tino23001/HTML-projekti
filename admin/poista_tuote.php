<?php
session_start();
include('config.php');

// Otetaan vastaan tuote_id, jonka perusteella poistetaan tuote tietokannasta
if(isset($_POST['tuote_id'])) {
    $tuote_id = $_POST['tuote_id'];

    // Ensin poistetaan tuotteeseen liittyvät arvostelut
    $sql_arvostelut = "DELETE FROM arvostelut WHERE tuote_id = :tuote_id";
    $stmt_arvostelut = $pdo->prepare($sql_arvostelut);
    $stmt_arvostelut->execute([':tuote_id' => $tuote_id]);

    // Sitten poistetaan itse tuote
    $sql_tuote = "DELETE FROM tuotteet WHERE tuote_id = :tuote_id";
    $stmt_tuote = $pdo->prepare($sql_tuote);
    $stmt_tuote->execute([':tuote_id' => $tuote_id]);

    echo "success";
} else {
    echo "Virhe: Tuote_id ei ole määritetty";
}
?>

