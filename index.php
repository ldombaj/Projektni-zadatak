<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
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
            <section class="Business" id="business-section">
                <h2>Business</h2>
                <div class="news">
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


                    $sql = "SELECT * FROM news WHERE kategorija = 'Business' AND arhivirano = 0";
                    $result = $dbc->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo '<article>';
                            echo '<a href="clanak.php?id=' . $row['id'] . '">';
                            echo '<h4>' . htmlspecialchars($row['naslov']) . '</h4>';
                            echo '<img src="' . htmlspecialchars($row['slika_url']) . '" alt="Business">';
                            echo '<p>' . htmlspecialchars($row['sazetak']) . '</p>';
                            echo '</a>';
                            echo '</article>';
                        }
                    } else {
                        echo "Nema news za prikaz.";
                    }

                    $dbc->close();
                    ?>
                </div>
            </section>
            <section class="Sport" id="sport-section">
                <h2>Sport</h2>
                <div class="news">
                    <?php

                    $dbc = new mysqli($servername, $username, $password, $database, $port);


                    if ($dbc->connect_error) {
                        die("Povezivanje na bazu nije uspjelo: " . $dbc->connect_error);
                    }


                    $sql = "SELECT * FROM news WHERE kategorija = 'Sport' AND arhivirano = 0";
                    $result = $dbc->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo '<article>';
                            echo '<a href="clanak.php?id=' . $row['id'] . '">';
                            echo '<h4>' . htmlspecialchars($row['naslov']) . '</h4>';
                            echo '<img src="' . htmlspecialchars($row['slika_url']) . '" alt="Sport">';
                            echo '<p>' . htmlspecialchars($row['sazetak']) . '</p>';
                            echo '</a>';
                            echo '</article>';
                        }
                    } else {
                        echo "Nema news za prikaz.";
                    }

                    $dbc->close();
                    ?>
                </div>
            </section>
        </main>
    </div>
    <footer>
        <p>Author: Luka Dombaj | Email: ldombaj@tvz.hr | Year: 2024</p>
    </footer>
</body>
</html>
