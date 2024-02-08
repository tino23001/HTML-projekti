<?php include('../config.php'); ?>

<?php
$sql = "UPDATE tuotteet SET
nimi = ?,
hinta = ?,
kuvaus = ?
WHERE tuote_id = ? LIMIT 1";

$stmt = $pdo->prepare($sql);

//*BIND
$id = $_POST['tuote_id'];
$nimi = $_POST['product_name'];
$hinta = $_POST['product_price'];
$kuvaus = $_POST['product_description'];

$stmt->execute([$nimi, $hinta, $kuvaus, $id]);

$pdo->connection = null;
?>
