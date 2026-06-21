<?php
include 'connect.php';

// Ako je forma poslana - spremi u bazu
if (isset($_POST['title'])) {

    $title    = $_POST['title'];
    $about    = $_POST['about'];
    $content  = $_POST['content'];
    $category = $_POST['category'];
    $date     = date('d.m.Y.');
    $archive  = isset($_POST['archive']) ? 1 : 0;

    $picture = $_FILES['pphoto']['name'];
    if ($picture != '') {
        $target_dir = 'img/' . $picture;
        move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);
    }

    $sql  = "INSERT INTO vijesti 
            (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssssssi', 
            $date, $title, $about, $content, $picture, $category, $archive);
        mysqli_stmt_execute($stmt);
    }

    mysqli_close($dbc);

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News – Unos vijesti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-inner">
        <div class="bbc-logo">BBC</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?id=news">News</a></li>
                <li><a href="kategorija.php?id=sport">Sport</a></li>
                <li class="active"><a href="unos.php">Unos</a></li>
                <li><a href="administrator.php">Administracija</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="category-bar">
    <h2>UNOS VIJESTI</h2>
</div>

<main>
    <div class="form-container">

        <form 
            name="unosvijesti" 
            action="unos.php" 
            method="POST" 
            enctype="multipart/form-data"
        >

            <div class="form-item">
                <label for="title">Naslov vijesti:</label>
                <div class="form-field">
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="form-field-textual"
                        autofocus
                        required
                    >
                </div>
            </div>

            <div class="form-item">
                <label for="about">Kratki sažetak vijesti:</label>
                <div class="form-field">
                    <textarea 
                        name="about" 
                        id="about" 
                        cols="30" 
                        rows="4" 
                        class="form-field-textual"
                        required
                    ></textarea>
                </div>
            </div>

            <div class="form-item">
                <label for="content">Sadržaj vijesti:</label>
                <div class="form-field">
                    <textarea 
                        name="content" 
                        id="content" 
                        cols="30" 
                        rows="10" 
                        class="form-field-textual"
                        required
                    ></textarea>
                </div>
            </div>

            <div class="form-item">
                <label for="pphoto">Slika:</label>
                <div class="form-field">
                    <input 
                        type="file" 
                        name="pphoto" 
                        id="pphoto"
                        accept="image/jpg, image/jpeg, image/gif, image/png"
                    >
                </div>
            </div>

            <div class="form-item">
                <label for="category">Kategorija vijesti:</label>
                <div class="form-field">
                    <select 
                        name="category" 
                        id="category" 
                        class="form-field-textual"
                    >
                        <option value="news">News</option>
                        <option value="sport">Sport</option>
                    </select>
                </div>
            </div>

            <div class="form-item">
                <label>
                    Spremiti u arhivu:
                    <div class="form-field">
                        <input 
                            type="checkbox" 
                            name="archive" 
                            id="archive"
                        > Da, arhiviraj
                    </div>
                </label>
            </div>

            <div class="form-item">
                <button type="reset">Poništi</button>
                <button type="submit">Prihvati</button>
            </div>

        </form>

    </div>
</main>

<footer>
    <p>
        <strong>Copyright &copy; 2019 BBC.</strong> 
        The BBC is not responsible for the content of external sites. 
        <a href="#">Read about our approach to external linking.</a>
    </p>
    <p>Marija Kučinić | mkucinic@tvz.hr | 2026.</p>
</footer>

</body>
</html>