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
 
<div class="grid-container">
    <div class="content">

            <header class="site-header">
                <div class="site-header__wrapper">
                    <a href="admin.php" class="home-logo">LOHIKÄRMES</a>
                    <div class="menu-icon" onclick="toggleMenu()" aria-label="Avaa valikko">☰</div>
                    <nav class="nav">
                        <a href="admin.php">ADMIN</a>
                        <a href="kauppaedit.php">TUOTELISTA</a>
                        <a href="lisaatuote.php">TUOTTEEN LISÄYS</a>
                    </nav>
                </div>
            </header>
    </div>
    
    <section class="muokkaa_otsikko">
        <h1 class="otsikko_muotoilu">Muokkaa tuotetta</h1>


        <section class="muokkaa_kehys">

            <?php
                if (isset($_GET['tuote_id'])) {
                    $tuote_id = $_GET['tuote_id'];

                    // Haetaan tietokannasta yksittäisen tuotteen tiedot
                    $sql = "SELECT * FROM tuotteet WHERE tuote_id = :tuote_id";
                    $statement = $pdo->prepare($sql);
                    $statement->bindParam(':tuote_id', $tuote_id, PDO::PARAM_INT);
                    $statement->execute();
                    $tuote = $statement->fetch(PDO::FETCH_ASSOC);

                    // Tulosta tuotteen tiedot ja kentät
                        echo "<img src='../uploads/" . htmlspecialchars($tuote['kuva']) . "' alt='" . htmlspecialchars($tuote['nimi']) . "'>";
                        echo '<div><p> Nimi <br><input type="text" name="product_name" value="' . htmlspecialchars($tuote['nimi']) . '"> </p>'; 
                        echo '<p> Hinta <br><input type="text" name="product_price" value="' . htmlspecialchars($tuote['hinta']) . '"> </p>';
                        echo '<p> Kuvaus <br><textarea class="kuvaus" name="product_description" placeholder="Syötä kuvaus tähän">' . htmlspecialchars($tuote['kuvaus']) . '</textarea></p>';
                        echo '<button class="tallennaMuokkaus">Tallenna muutokset</button>';
                        echo "</div>";
                                

                } else {
                    echo "Tuote_id-parametri puuttuu.";
                }

            ?>
            <script>
                $(document).ready(function(){
                    $(".tallennaMuokkaus").click(function() {
                        // Tarkista, että kaikki kentät ovat täytetty
                        var nimi = $("input[name='product_name']").val();
                        var hinta = $("input[name='product_price']").val();
                        var kuvaus = $("textarea[name='product_description']").val();
                        //Ongelma tässä osuudessa
                        if (nimi === '' || hinta === '' || kuvaus === '' || $count > 0 || !/^[a-zA-Z0-9]{1,30}$/.test($productName) || $productPrice <= 0 || isNaN($productPrice)) {
                            if (nimi === '' || hinta === '' || kuvaus === '') {
                                alert("Kaikki kentät on täytettävä ennen muutosten tallentamista.");
                            } else if ($count > 0) { 
                                alert("Tuote nimellä '{$productName}' on jo olemassa. Valitse toinen nimi.");
                            } else if (!/^[a-zA-Z0-9]{1,30}$/.test($productName)) {
                                alert("Tarkista tuotteen nimi. Nimen pituus ei saa ylittää 30 merkkiä ja sen tulee sisältää vain kirjaimia ja numeroita.");
                            } else if ($productPrice <= 0 || isNaN($productPrice)) {
                                alert(" Hinnan tulee olla positiivinen numero.");
                            }
                            return;
                        }
                        //Ongelma loppuu
                        var vahvistus = confirm("Haluatko varmasti tallentaa muutokset?");
                        if (vahvistus) {
                            var tuote_id = <?php echo $tuote_id; ?>;
                            var nimi = $("input[name='product_name']").val();
                            var hinta = $("input[name='product_price']").val();
                            var kuvaus = $("textarea[name='product_description']").val();
                            
                            $.post("tallenna_muutokset.php", { tuote_id: tuote_id, product_name: nimi, product_price: hinta, product_description: kuvaus })
                                .done(function(response) {
                                    if(response.trim() === "success") {
                                        alert("Tuote muokattu onnistuneesti!");
                                        // Voit tässä vaiheessa päivittää sivun tai tehdä muita toimenpiteitä tarpeen mukaan
                                    } else {
                                        alert("Tuotetta ei voitu muokata.");
                                    }
                                })
                                .fail(function() {
                                    alert("Virhe tuotetta muokatessa.");
                                });
                        } else {
                            alert("Tuotetta ei muokattu.");
                        }
                    });
                });
            </script>



        </section>
    </section>

    <div class="footer-bottom-admin">
                © Lohikärmes 2024
    </div>
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