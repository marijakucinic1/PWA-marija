<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = false;
$admin           = false;
$msg             = '';
$imeKorisnika    = '';

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: administrator.php');
    exit();
}

// PROVJERA LOGIN FORME
if (isset($_POST['prijava'])) {

    $prijavaUsername = $_POST['username'];
    $prijavaLozinka  = $_POST['lozinka'];

    // Prepared statement - zaštita od SQL injection
    $sql  = "SELECT korisnicko_ime, lozinka, razina FROM korisnik 
             WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaUsername);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
        mysqli_stmt_fetch($stmt);
    }

    // Provjera lozinke
    if (mysqli_stmt_num_rows($stmt) > 0 && 
        password_verify($prijavaLozinka, $lozinkaKorisnika)) {

        $uspjesnaPrijava = true;

        // Spremi u session
        $_SESSION['username'] = $imeKorisnika;
        $_SESSION['level']    = $levelKorisnika;

        if ($levelKorisnika == 1) {
            $admin = true;
        }

    } else {
        $msg = 'Pogrešno korisničko ime ili lozinka. 
                <a href="registracija.php">Registriraj se ovdje.</a>';
    }
}

// Provjeri session ako je već prijavljen
if (isset($_SESSION['username'])) {
    $imeKorisnika = $_SESSION['username'];
    if ($_SESSION['level'] == 1) {
        $admin           = true;
        $uspjesnaPrijava = true;
    }
}

// BRISANJE - prepared statement
if (isset($_POST['delete']) && $admin == true) {
    $id   = $_POST['id'];
    $sql  = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    }
    header('Location: administrator.php');
    exit();
}

// UPDATE - prepared statement
if (isset($_POST['update']) && $admin == true) {
    $id       = $_POST['id'];
    $title    = $_POST['title'];
    $about    = $_POST['about'];
    $content  = $_POST['content'];
    $category = $_POST['category'];
    $archive  = isset($_POST['archive']) ? 1 : 0;

    $picture = $_FILES['pphoto']['name'];
    if ($picture != '') {
        move_uploaded_file($_FILES['pphoto']['tmp_name'], 'img/' . $picture);
    } else {
        $sql_old  = "SELECT slika FROM vijesti WHERE id = ?";
        $stmt_old = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt_old, $sql_old)) {
            mysqli_stmt_bind_param($stmt_old, 'i', $id);
            mysqli_stmt_execute($stmt_old);
            mysqli_stmt_bind_result($stmt_old, $picture);
            mysqli_stmt_fetch($stmt_old);
        }
    }

    $sql  = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, 
             slika=?, kategorija=?, arhiva=? WHERE id=?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sssssii', 
            $title, $about, $content, $picture, $category, $archive, $id);
        mysqli_stmt_execute($stmt);
    }
    header('Location: administrator.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News – Administracija</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
    <div class="header-inner">
        <div class="bbc-logo">BBC</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?id=news">News</a></li>
                <li><a href="kategorija.php?id=sport">Sport</a></li>
                <li><a href="unos.php">Unos</a></li>
                <li class="active"><a href="administrator.php">Administracija</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="category-bar">
    <h2>ADMINISTRACIJA</h2>
</div>

<main>
    <div class="form-container">

    <?php
    // SLUČAJ 1 - korisnik je admin
    if ($admin == true) {
    ?>
        <p style="margin-bottom:20px;">
            Dobrodošao/la, <strong><?php echo $imeKorisnika; ?></strong>! 
            <a href="administrator.php?logout=1" 
               style="color:red; margin-left:20px;">Odjava</a>
        </p>

        <?php
        $query  = "SELECT * FROM vijesti ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 0) {
            echo '<p>Nema vijesti u bazi.</p>';
        }

        while ($row = mysqli_fetch_array($result)) {
            echo '
            <div style="border:1px solid #ccc; padding:20px; margin-bottom:30px;">
                <form enctype="multipart/form-data" 
                      action="administrator.php" method="POST">

                    <input type="hidden" name="id" value="' . $row['id'] . '">

                    <div class="form-item">
                        <label>Naslov vijesti:</label>
                        <div class="form-field">
                            <input type="text" name="title" 
                                   class="form-field-textual" 
                                   value="' . htmlspecialchars($row['naslov']) . '">
                        </div>
                    </div>

                    <div class="form-item">
                        <label>Kratki sažetak:</label>
                        <div class="form-field">
                            <textarea name="about" cols="30" rows="4" 
                                      class="form-field-textual">'
                                      . htmlspecialchars($row['sazetak']) .
                            '</textarea>
                        </div>
                    </div>

                    <div class="form-item">
                        <label>Sadržaj vijesti:</label>
                        <div class="form-field">
                            <textarea name="content" cols="30" rows="6" 
                                      class="form-field-textual">'
                                      . htmlspecialchars($row['tekst']) .
                            '</textarea>
                        </div>
                    </div>

                    <div class="form-item">
                        <label>Slika:</label>
                        <div class="form-field">
                            <img src="' . UPLPATH . $row['slika'] . '" 
                                 width="100px" 
                                 style="display:block; margin-bottom:5px;">
                            <input type="file" name="pphoto">
                        </div>
                    </div>

                    <div class="form-item">
                        <label>Kategorija:</label>
                        <div class="form-field">
                            <select name="category" class="form-field-textual">';

                            if ($row['kategorija'] == 'news') {
                                echo '<option value="news" selected>News</option>
                                      <option value="sport">Sport</option>';
                            } else {
                                echo '<option value="news">News</option>
                                      <option value="sport" selected>Sport</option>';
                            }

                    echo '</select>
                        </div>
                    </div>

                    <div class="form-item">
                        <label>Arhiva:</label>';

                        if ($row['arhiva'] == 0) {
                            echo '<input type="checkbox" name="archive"> Arhiviraj?';
                        } else {
                            echo '<input type="checkbox" name="archive" checked> Arhiviraj?';
                        }

                    echo '</div>

                    <div class="form-item">
                        <button type="reset">Poništi</button>
                        <button type="submit" name="update">Izmjeni</button>
                        <button type="submit" name="delete" 
                                onclick="return confirm(\'Obrisati vijest?\')">
                            Izbriši
                        </button>
                    </div>

                </form>
            </div>';
        }

    // SLUČAJ 2 - prijavljen ali nije admin
    } else if ($uspjesnaPrijava == true && $admin == false) {
    ?>
        <p>Bok <strong><?php echo $imeKorisnika; ?></strong>! 
           Uspješno ste prijavljeni, ali nemate pravo pristupa 
           administratorskoj stranici.</p>
        <p><a href="administrator.php?logout=1">Odjava</a></p>

    <?php
    // SLUČAJ 3 - nije prijavljen, prikaži login formu
    } else {
    ?>
        <?php if ($msg != '') { ?>
            <p style="color:red; margin-bottom:15px;">
                <?php echo $msg; ?>
            </p>
        <?php } ?>

        <h2 style="margin-bottom:20px;">Prijava</h2>

        <form name="login" action="administrator.php" method="POST">

            <div class="form-item">
                <label for="username">Korisničko ime:</label>
                <div class="form-field">
                    <input type="text" name="username" id="username" 
                           class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <label for="lozinka">Lozinka:</label>
                <div class="form-field">
                    <input type="password" name="lozinka" id="lozinka" 
                           class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <button type="submit" name="prijava">Prijava</button>
                <a href="registracija.php" 
                   style="margin-left:15px;">Nemaš račun? Registriraj se</a>
            </div>

        </form>

    <?php } ?>

    </div>
</main>

<footer>
    <p>
        <strong>Copyright &copy; 2019 BBC.</strong>
        The BBC is not responsible for the content of external sites.
        <a href="#">Read about our approach to external linking.</a>
    </p>
</footer>

</body>
</html>