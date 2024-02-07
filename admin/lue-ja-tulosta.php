<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lue ja tulosta</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz@8..144&family=Snippet&family=Source+Sans+3&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined', sans-serif;
            font-size: 2em; /* Voit säätää fonttikokoa tarpeidesi mukaan */
        }
    </style>
</head>
<?php include('config.php'); ?>

<body>
    <header class="site-header">
        <div class="site-header__wrapper">
            <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
        </div>
    </header>
        <section class="taulukko-container">
            <h1 class="otsikko_muotoilu">Tuotteet</h1>
            <p><a href="lisaatuote.html">Lisää tuote</a></p>

    <?php
        $sql = "SELECT tuote_id, nimi, hinta FROM tuotteet";

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $tuotteet = $statement->fetchAll(PDO::FETCH_ASSOC);

        //tuote_id, nimi, hinta
        echo "<table border='1'>
        <tr>
        <th>tuote_id</th>
        <th>nimi</th>
        <th>hinta</th>
        </tr>";

        foreach ($tuotteet as $tuote) {
            echo "<tr>";
            echo "<td>" . $tuote['tuote_id'] . "</td>";
            echo "<td>" . $tuote['nimi'] . "</td>";
            echo "<td>" . $tuote['hinta'] . "</td>";
            echo "<td><a href='muokkaatuotetta.php?id=" . $tuote['tuote_id'] . "'>Muokkaa tuotetta</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    
        $pdo->connection = null;

    ?>
    </section>

    <footer>
        <div class="footer-container">
            <p>© Lohikärmes 2024</p>
        </div>
    </footer>

</body>
</html>