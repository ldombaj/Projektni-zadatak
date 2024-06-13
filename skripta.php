<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New news</title>
    <link rel="stylesheet" href="style.css">
    <style>
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
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
            <section id="specific_news">
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

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $title = htmlspecialchars($_POST['title']);
                    $summary = htmlspecialchars($_POST['summary']);
                    $content = htmlspecialchars($_POST['content']);
                    $category = htmlspecialchars($_POST['category']);
                    $display = isset($_POST['display']) ? 1 : 0; 


                    echo '<h2>' . $category . '</h2>';
                    echo '<h2>' . $title . '</h2>';
                    echo '<p>' . $summary . '</p>';

                    $uploadDir = 'images/';
                    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
                    echo '<img src="' . $uploadFile . '" alt="News Image">';

                    echo '<p>' . $content . '</p>';

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {

                        $image_url = $uploadFile;

                        $sql = "INSERT INTO news (naslov, sazetak, sadrzaj, kategorija, slika_url, arhivirano) 
                                VALUES ('$title', '$summary', '$content', '$category', '$image_url', $display)";

                        if ($dbc->query($sql) === TRUE) {

                        } else {

                        }
                    } else {

                    }
                } else {

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
