<?php
include('config.php');

// Otetaan vastaan tuote_id, jonka perusteella poistetaan tuote tietokannasta
if(isset($_POST['tuote_id'])) {
    $tuote_id = $_POST['tuote_id'];

    try {
        // Ensin poistetaan tuotteeseen liittyvät arvostelut
        $sql_arvostelut = "DELETE FROM arvostelut WHERE tuote_id = :tuote_id";
        $stmt_arvostelut = $pdo->prepare($sql_arvostelut);
        $stmt_arvostelut->execute([':tuote_id' => $tuote_id]);

        // Sitten poistetaan itse tuote
        $sql_tuote = "DELETE FROM tuotteet WHERE tuote_id = :tuote_id";
        $stmt_tuote = $pdo->prepare($sql_tuote);
        $stmt_tuote->execute([':tuote_id' => $tuote_id]);

        echo "success";
    } catch (PDOException $e) {
        // Logaa virhe tai näytä se kehittäjälle
        error_log('Tuotteen poisto epäonnistui: ' . $e->getMessage());
        // Näytä yleisluontoinen virheviesti käyttäjälle
        echo "Virhe tuotetta poistettaessa. Ole hyvä ja yritä myöhemmin uudelleen.";
    }
} else {
    echo "Virhe: Tuote_id ei ole määritetty";
}
?>

