<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['kayttaja'])) {
            header("Location: admin.php");
            exit();
        }
        $kayttaja = $_POST['kayttaja'];
        if ($kayttaja == "admin") {
            $_SESSION['kayttaja'] = $kayttaja;
            header("Location: admin.php");
            exit();
        } else {
            echo "Väärä käyttäjätunnus!" . "<br>";
            echo "<a href='kirjautumissivu.php'>Takaisin</a>";
        }
    ?>

    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="kayttaja">Käyttäjä</label>
        <input type="text" name="kayttaja" id="kayttaja" required>
        <br>
        <label for="salasana">Salasana</label>
        <input type="password" name="salasana" id="salasana" required>
        <br>
        <input type="submit" value="Kirjaudu">
    </form>

</body>
</html>
