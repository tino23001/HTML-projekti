<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lohikärmes Kauppa</title>
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
<?php include('../config.php'); ?>
<body>
    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
        </div>
    </header>
    
    <section class="flex-kauppa">
        <span class="material-symbols-outlined" style="font-size: 3em;"> store </span> 
        <h1 class="otsikko_muotoilu">LOREM IPSUM </h1>
    </section>

    <store-page>
        <?php
            if (isset($_GET['tuote_id'])) {
                $tuote_id = $_GET['tuote_id'];

                // Haetaan tietokannasta yksittäisen tuotteen tiedot
                $sql = "SELECT * FROM tuotteet WHERE tuote_id = :tuote_id";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':tuote_id', $tuote_id, PDO::PARAM_INT);
                $statement->execute();
                $tuote = $statement->fetch(PDO::FETCH_ASSOC);

                // Tulosta tuotteen tiedot
                if ($tuote) {
                    echo "<div><img src='uploads/" . htmlspecialchars($tuote['kuva']) . "' alt='" . htmlspecialchars($tuote['nimi']) . "'></div>";
                    echo '<div><h2> Nimi: <input type="text" name="n" value="' . htmlspecialchars($tuote['nimi']) . '"> </h2>'; //rivi 50
                    echo '<p>Hinta: <input type="text" name="h" value="' . htmlspecialchars($tuote['hinta']) . '"> </p>';
                    echo '<p>Kuvaus: <input type="text" name="k" value="' . htmlspecialchars($tuote['kuvaus']) . '"></p>';
                    echo '<p><input type="submit" value="Tallenna tuote"></p>';
                    echo "</div>";
                }                

            } else {
                echo "Tuote_id-parametri puuttuu.";
            }

        ?>




</store-page>

    <footer>
        <div class="footer-bottom">
            © Lohikärmes 2024
        </div>
    </footer>
    
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