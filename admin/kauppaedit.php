<?php 
session_start(); 
include('config.php');
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuotelista</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined', sans-serif;
            font-size: 2em; /* Voit säätää fonttikokoa tarpeidesi mukaan */
        }
        .item button {
            margin-left: 10px;
            margin-right: 10px;
        }
    </style>    
</head>


    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
            <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
            <nav class="nav">
                <a href="admin.php">ADMIN</a>
                <a href="kauppaedit.php"><b>TUOTELISTA</b></a>
                <a href="lisaatuote.php">TUOTTEEN LISÄYS</a>
            </nav>
        </div>
    </header>
    
    <section class="flex-kauppa">
        <span class="material-symbols-outlined" style="font-size: 3em;"> store </span> 
        <h1 class="otsikko_muotoilu">LOREM IPSUM </h1>
    </section>

    <store-page>
<?php

// Hae kaikki tuotteet tietokannasta
$sql = "SELECT tuote_id, nimi, hinta, kuva FROM tuotteet";
$statement = $pdo->prepare($sql);
$statement->execute();
$tuotteet = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($tuotteet as $tuote) {
    echo "<div class='item' id='tuote_" . $tuote['tuote_id'] . "'>"; 
    echo "<img src='../uploads/" . htmlspecialchars($tuote['kuva']) . "' alt='" . htmlspecialchars($tuote['nimi']) . "'>";
    echo "<h3>" . htmlspecialchars($tuote['nimi']) . "</h3>";
    // Tuotteen kuvausta ei tulosteta
    echo "<p>" . number_format($tuote['hinta'], 2, ',', ' ') . " €</p>";
    echo "<a href='muokkaa.php?tuote_id=" . $tuote['tuote_id'] . "'><button>Muokkaa</button></a>";
    echo '<button class="poistaButton">Poista</button>'; 
    echo "</div>";
}

?>
<script>
$(document).ready(function(){
    $(".poistaButton").click(function() {
        var vahvistus = confirm("Haluatko varmasti poistaa tuotteen?");
        if (vahvistus) {
            var tuote_id = $(this).closest('.item').attr('id').replace('tuote_', '');
            $.post("poista_tuote.php", { tuote_id: tuote_id })
                .done(function(response) {
                    if(response.trim() === "success") {
                        alert("Tuote poistettu!");
                        $("#tuote_" + tuote_id).remove();
                    } else {
                        alert("Tuotetta ei voitu poistaa.");
                    }
                })
                .fail(function() {
                    alert("Virhe tuotetta poistettaessa.");
                });
        } else {
            alert("Tuotetta ei poistettu.");
        }
    });
});
</script>


</store-page>

        <div class="footer-bottom-admin2">
            © Lohikärmes 2024
        </div>
    
    <script>
      function toggleMenu() {
   var nav = document.querySelector('nav');
   var menuIcon = document.querySelector('.menu-icon');

   if (nav.style.display === 'block') {
       nav.style.display = 'none';
       menuIcon.setAttribute('aria-label', 'Avaa valikko');
   } else {
       nav.style.display = 'block';
       menuIcon.setAttribute('aria-label', 'Sulje valikko');
   }
}
   </script>

</body>
</html>