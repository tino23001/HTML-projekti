<?php 
    include('config.php');

    if(isset($_POST['tuote_id'])) {

        $tuote_id = $_POST['tuote_id'];
        $nimi = htmlspecialchars($_POST['product_name']);
        $hinta = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $kuvaus = htmlspecialchars($_POST['product_description']);

        $sql = "UPDATE tuotteet SET nimi = ?, hinta = ?, kuvaus = ? WHERE tuote_id = ?";
        $statement = $pdo->prepare($sql);
        $count = $stmt->fetchColumn();

        // Suorita SQL-lause
        if ($statement->execute([$nimi, $hinta, $kuvaus, $tuote_id])) {
            // Päivitys onnistui
            echo "success";
        } else {
            // Päivitys epäonnistui
            echo "failure";
        }
    } else {
        echo "Virhe: Tuote_id ei ole määritetty";
    }

    $pdo = null;
?>
