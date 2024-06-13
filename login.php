<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    header("Location: administrator.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "news";
$port = 3307;  


$dbc = mysqli_connect($servername, $username, $password, $database, $port);


if (!$dbc) {
    die("Neuspjelo spajanje na bazu podataka: " . mysqli_connect_error());
}


if (isset($_POST['prijava'])) {
    $prijavaImeKorisnika = $_POST['username'];
    $prijavaLozinkaKorisnika = $_POST['lozinka'];
    

    $sql = "SELECT id, ime, prezime, korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    

    mysqli_stmt_bind_result($stmt, $idKorisnika, $imeKorisnika, $prezimeKorisnika, $korisnickoImeKorisnika, $lozinkaKorisnika, $razinaKorisnika);
    mysqli_stmt_fetch($stmt);
    

    if (password_verify($prijavaLozinkaKorisnika, $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['id'] = $idKorisnika;
        $_SESSION['username'] = $korisnickoImeKorisnika;
        $_SESSION['ime'] = $imeKorisnika;
        $_SESSION['prezime'] = $prezimeKorisnika;
        $_SESSION['level'] = $razinaKorisnika;
        
        header("Location: administrator.php");
        exit();
    } else {
        $poruka = "Pogrešno korisničko ime ili lozinka.";
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <h1>News</h1>
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
            <section class="Login" id="business-section">
                <h2>Prijava</h2>
                <form action="login.php" method="POST">
                    <?php if (isset($poruka)) echo "<p class='error'>$poruka</p>"; ?>
                    <label for="username"><b>Korisničko ime</b></label>
                    <input type="text" placeholder="Unesite korisničko ime" name="username" required>

                    <label for="lozinka"><b>Lozinka</b></label>
                    <input type="password" placeholder="Unesite lozinku" name="lozinka" required>

                    <button type="submit" name="prijava">Prijavi se</button>
                </form>
            </section>
        </main>
    </div>
    <footer>
        <p>Author: Luka Dombaj | Email: ldombaj@tvz.hr | Year: 2024</p>
    </footer>
</body>
</html>

