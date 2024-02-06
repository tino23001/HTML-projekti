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
// Sisällytä tietokantayhteyden määrittelyt
include('config.php');

// Otetaan vastaan tuote_id, jonka perusteella poistetaan tuote tietokannasta
if(isset($_POST['tuote_id'])) {

    // Poistetaan tuote tietokannasta
    $tuote_id = $_POST['tuote_id'];
    $sql = "DELETE FROM tuotteet WHERE tuote_id = :tuote_id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':tuote_id' => $tuote_id]);

    echo "Tuote poistettu onnistuneesti";
} else {
    echo "Virhe: Tuote_id ei ole määritetty";
}
?>

?>
</body>
</html>




