<?php
include 'connect.php';
define('UPLPATH', 'img/');

// Dohvati kategoriju iz URL-a
if (isset($_GET['id'])) {
    $kategorija = $_GET['id'];
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News – <?php echo strtoupper($kategorija); ?></title>
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
    <h2><?php echo strtoupper($kategorija); ?></h2>
</div>

<main>
    <div class="container">
        <div class="articles-grid">
        <?php
           $sql  = "SELECT * FROM vijesti 
            WHERE arhiva=0 AND kategorija = ? 
            ORDER BY id DESC";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $kategorija);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    if (mysqli_num_rows($result) == 0) {
        echo '<p>Nema vijesti u ovoj kategoriji.</p>';
    }
    while ($row = mysqli_fetch_array($result)) {
                echo '<article class="article-card">';
                echo '<a href="clanak.php?id=' . $row['id'] . '">';
                echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                echo '</a>';
                echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . $row['naslov'] . '</a></h3>';
                echo '<p>' . $row['sazetak'] . '</p>';
                echo '</article>';
            }
        ?>
        </div>
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