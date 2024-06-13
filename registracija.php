<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "news";
    $port = 3307;

    $dbc = new mysqli($servername, $username, $password, $database, $port);

    if ($dbc->connect_error) {
        die("Povezivanje na bazu nije uspjelo: " . $dbc->connect_error);
    }

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];
    $hashed_lozinka = password_hash($lozinka, PASSWORD_DEFAULT);
    $razina = 0; // Postavljamo level na 0 za sve nove korisnike

    $stmt = $dbc->prepare("INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $ime, $prezime, $korisnicko_ime, $hashed_lozinka, $razina);

    if ($stmt->execute()) {
        $poruka = "Uspješno ste se registrirali!";
    } else {
        $poruka = "Registracija nije uspjela.";
    }

    $dbc->close();
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Registracija</h1>
        <hr class="blue-line">
        <nav>
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="business_category.html">BUSINESS</a></li>
                <li><a href="sport_category.html">SPORT</a></li>
                <li><a href="unos.html">UNOS</a></li>
                <li><a href="index.php">DODANE VIJESTI</a></li>
                <li><a href="administrator.php">ADMINISTRATOR</a></li>
                <li><a href="login.php">PRIJAVA</a></li>
                <li><a href="registracija.php">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>
    <div class="main-container">
        <main>
            <section id="registration-form">
                <h2>Registracija korisnika</h2>
                <form action="registracija.php" method="POST">
                    <label for="ime">Ime:</label><br>
                    <input type="text" id="ime" name="ime" required><br><br>

                    <label for="prezime">Prezime:</label><br>
                    <input type="text" id="prezime" name="prezime" required><br><br>

                    <label for="korisnicko_ime">Korisničko ime:</label><br>
                    <input type="text" id="korisnicko_ime" name="korisnicko_ime" required><br><br>

                    <label for="lozinka">Lozinka:</label><br>
                    <input type="password" id="lozinka" name="lozinka" required><br><br>

                    <input type="submit" value="Registriraj se">
                </form>
                <?php if (isset($poruka)) : ?>
                    <p><?php echo $poruka; ?></p>
                <?php endif; ?>
            </section>
        </main>
    </div>
    <footer>
        <p>Author: Luka Dombaj | Email: ldombaj@tvz.hr | Year: 2024</p>
    </footer>
</body>
</html>
