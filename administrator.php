<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
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
        <section id="admin-news">
            <h2>Uredi ili obriši vijest</h2>
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

            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                $query = "DELETE FROM news WHERE id=$id";
                $dbc->query($query);
            }

            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $summary = $_POST['summary'];
                $content = $_POST['content'];
                $category = $_POST['category'];
                $archive = isset($_POST['archive']) ? 1 : 0;

                if (!empty($_FILES['image']['name'])) {
                    $image_url = 'images/' . basename($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], $image_url);
                    $query = "UPDATE news SET naslov='$title', sazetak='$summary', sadrzaj='$content', kategorija='$category', arhivirano='$archive', slika_url='$image_url' WHERE id=$id";
                } else {
                    $query = "UPDATE news SET naslov='$title', sazetak='$summary', sadrzaj='$content', kategorija='$category', arhivirano='$archive' WHERE id=$id";
                }

                $dbc->query($query);
            }

            $query = "SELECT * FROM news";
            $result = $dbc->query($query);

            while ($row = $result->fetch_assoc()) {
                echo '<form enctype="multipart/form-data" action="" method="POST">
                    <div class="form-item">
                        <label for="title">Naslov vijesti:</label>
                        <div class="form-field">
                            <input type="text" name="title" class="form-field-textual" value="' . htmlspecialchars($row['naslov']) . '">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="summary">Kratki sadržaj vijesti (do 50 znakova):</label>
                        <div class="form-field">
                            <textarea name="summary" cols="30" rows="10" class="form-field-textual">' . htmlspecialchars($row['sazetak']) . '</textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="content">Sadržaj vijesti:</label>
                        <div class="form-field">
                            <textarea name="content" cols="30" rows="10" class="form-field-textual">' . htmlspecialchars($row['sadrzaj']) . '</textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="image">Slika:</label>
                        <div class="form-field">
                            <input type="file" class="input-text" id="image" name="image"/>
                            <br><img src="' . htmlspecialchars($row['slika_url']) . '" width=100px>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="category">Kategorija vijesti:</label>
                        <div class="form-field">
                            <select name="category" class="form-field-textual">
                                <option value="Business"' . ($row['kategorija'] == 'Business' ? ' selected' : '') . '>Business</option>
                                <option value="Sport"' . ($row['kategorija'] == 'Sport' ? ' selected' : '') . '>Sport</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        <label>Spremiti u arhivu:
                        <div class="form-field">';
                if ($row['arhivirano'] == 0) {
                    echo '<input type="checkbox" name="archive"/> Arhiviraj?';
                } else {
                    echo '<input type="checkbox" name="archive" checked/> Arhiviraj?';
                }
                echo '</div>
                        </label>
                    </div>
                    <div class="form-item">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <button type="reset">Poništi</button>
                        <button type="submit" name="update">Izmjeni</button>
                        <button type="submit" name="delete">Izbriši</button>
                    </div>
                </form>';
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