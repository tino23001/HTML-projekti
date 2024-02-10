<?php
session_start();
include('config.php');

// Otetaan vastaan tuote_id, jonka perusteella poistetaan tuote tietokannasta
if(isset($_POST['tuote_id'])) {
        // Poistetaan tuote tietokannasta
        $tuote_id = $_POST['tuote_id'];
        $sql = "DELETE FROM tuotteet WHERE tuote_id = :tuote_id";
        $sql = "DELETE FROM arvostelut WHERE tuote_id = :tuote_id";
        $statement = $pdo->prepare($sql);
        $statement->execute([':tuote_id' => $tuote_id]);

        echo "success";

} else {
    echo "Virhe: Tuote_id ei ole määritetty";
}
?>

