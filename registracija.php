<?php
session_start();
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if (isset($_POST['submit'])) {

    $ime      = mysqli_real_escape_string($dbc, $_POST['ime']);
    $prezime  = mysqli_real_escape_string($dbc, $_POST['prezime']);
    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $lozinka  = $_POST['pass'];
    $lozinka2 = $_POST['passRep'];
    $razina   = 0;

    // Provjera podudaranja lozinki
    if ($lozinka !== $lozinka2) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {

        // Provjera postoji li korisničko ime već u bazi
        $sql  = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            // Hashiraj lozinku
            $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

            // Unesi korisnika u bazu
            $sql  = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssssi', 
                    $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
            }
        }
    }

    mysqli_close($dbc);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News – Registracija</title>
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
                <li><a href="administrator.php">Administracija</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="category-bar">
    <h2>REGISTRACIJA</h2>
</div>

<main>
    <div class="form-container">

        <?php if ($registriranKorisnik == true) { ?>

            <p style="color:green; font-size:16px;">
                Korisnik je uspješno registriran! 
                <a href="administrator.php">Idi na prijavu →</a>
            </p>

        <?php } else { ?>

            <?php if ($msg != '') { ?>
                <p style="color:red; margin-bottom:15px;"><?php echo $msg; ?></p>
            <?php } ?>

            <form name="registracija" action="registracija.php" method="POST">

                <div class="form-item">
                    <label for="ime">Ime:</label>
                    <div class="form-field">
                        <input type="text" name="ime" id="ime" 
                               class="form-field-textual" required>
                    </div>
                </div>

                <div class="form-item">
                    <label for="prezime">Prezime:</label>
                    <div class="form-field">
                        <input type="text" name="prezime" id="prezime" 
                               class="form-field-textual" required>
                    </div>
                </div>

                <div class="form-item">
                    <label for="username">Korisničko ime:</label>
                    <div class="form-field">
                        <input type="text" name="username" id="username" 
                               class="form-field-textual" required>
                    </div>
                </div>

                <div class="form-item">
                    <label for="pass">Lozinka:</label>
                    <div class="form-field">
                        <input type="password" name="pass" id="pass" 
                               class="form-field-textual" required>
                    </div>
                </div>

                <div class="form-item">
                    <label for="passRep">Ponovite lozinku:</label>
                    <div class="form-field">
                        <input type="password" name="passRep" id="passRep" 
                               class="form-field-textual" required>
                    </div>
                </div>

                <div class="form-item">
                    <button type="reset">Poništi</button>
                    <button type="submit" name="submit">Registriraj se</button>
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
    <p>Marija Kučinić | mkucinic@tvz.hr | 2026.</p>
</footer>

</body>
</html>