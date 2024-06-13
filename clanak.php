<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business News</title>
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
            <section class="Business" id="specific_news">
                <?php
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "news";
                $port = 3307;

                $dbc = new mysqli($servername, $username, $password, $database, $port);

                
                if ($dbc->connect_error) {
                    die("Povezivanje na bazu nije uspjelo: " . $dbc->connect_error);
                }

                
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);

                    
                    $stmt = $dbc->prepare("SELECT naslov, sazetak, sadrzaj, kategorija, slika_url FROM news WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($naslov, $sazetak, $sadrzaj, $kategorija, $slika_url);

                    
                    if ($stmt->fetch()) {
                        echo '<h2>' . htmlspecialchars($kategorija) . '</h2>';
                        echo '<div class="news">';
                        echo '<article>';
                        echo '<h3>' . htmlspecialchars($naslov) . '</h3>';
                        echo '<p>' . htmlspecialchars($sazetak) . '</p>';
                        echo '<img src="' . htmlspecialchars($slika_url) . '" alt="News Image">';
                        echo '<p>' . htmlspecialchars($sadrzaj) . '</p>';
                        echo '</article>';
                        echo '</div>';
                    } else {
                        echo '<p>Članak nije pronađen.</p>';
                    }

                    $stmt->close();
                } else {
                    echo '<p>ID članka nije postavljen.</p>';
                }

                $dbc->close();
                ?>
            </section>
        </main>
    </div>
    <footer>
        <p>Author: Luka Dombaj | Email: ldombaj@tvz.hr | Year: 2024</p>
    </footer>
</body>
</html>
