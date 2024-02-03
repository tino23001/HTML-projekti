<?php

// Näyttää virheet
error_reporting(E_ALL);
ini_set("display_errors", 1);


//tietokanta-asetukset
$palvelin = "localhost";
$kayttajatunnus = "trtkm23a_19";
$salasana = "";
$tietokanta = "wp_trtkm23a_19";

try {
    $pdo = new PDO("mysql:host=$palvelin;dbname=$tietokanta", $kayttajatunnus, $salasana);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Saattaa korjata mahdollisen ääkkösongelman
     $pdo->exec("SET NAMES 'utf8';");
    }
catch(PDOException $e)
    {
    echo "<p>Yhteys epäonnistui</p><p>" . $e->getMessage() . "</p>";
    
    }



?>