<?php
include 'connect.php';
define('UPLPATH', 'img/');
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
    <div class="header-inner">
        <div class="bbc-logo">BBC</div>
        <nav>
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?id=news">News</a></li>
                <li><a href="kategorija.php?id=sport">Sport</a></li>
                <li><a href="unos.php">Unos</a></li>
                <li><a href="administrator.php">Administracija</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">

        <div class="welcome-bar">
            <h1>Welcome to BBC.com</h1>
            <span class="datum"><?php echo date('l, d F'); ?></span>
        </div>

        <!-- SEKCIJA NEWS -->
        <section>
            <h2 class="section-title">News</h2>
            <div class="articles-grid">
            <?php
                $query = "SELECT * FROM vijesti 
                          WHERE arhiva=0 AND kategorija='news' 
                          ORDER BY id DESC LIMIT 3";
                $result = mysqli_query($dbc, $query);

                if (mysqli_num_rows($result) == 0) {
                    echo '<p>Nema vijesti u kategoriji News.</p>';
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
        </section>

        <!-- SEKCIJA SPORT -->
        <section>
            <h2 class="section-title sport">Sport</h2>
            <div class="articles-grid">
            <?php
                $query = "SELECT * FROM vijesti 
                          WHERE arhiva=0 AND kategorija='sport' 
                          ORDER BY id DESC LIMIT 3";
                $result = mysqli_query($dbc, $query);

                if (mysqli_num_rows($result) == 0) {
                    echo '<p>Nema vijesti u kategoriji Sport.</p>';
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
        </section>

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