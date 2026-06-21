<?php
include 'connect.php';
define('UPLPATH', 'img/');

// Dohvati id iz URL-a
$id   = $_GET['id'];
$sql  = "SELECT * FROM vijesti WHERE id = ?";
$stmt = mysqli_stmt_init($dbc);

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row    = mysqli_fetch_array($result);
}

// Ako članak ne postoji
if (!$row) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News – <?php echo $row['naslov']; ?></title>
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
    <h2><?php echo strtoupper($row['kategorija']); ?></h2>
</div>

<main>
    <div class="article-detail">

        <h1><?php echo $row['naslov']; ?></h1>

        <p><strong>AUTOR:</strong> BBC News</p>
        <p><strong>OBJAVLJENO:</strong> <?php echo $row['datum']; ?></p>

        <br>

        <?php if ($row['slika'] != '') { ?>
            <img 
                src="<?php echo UPLPATH . $row['slika']; ?>" 
                alt="<?php echo $row['naslov']; ?>"
                class="article-image"
            >
        <?php } ?>

        <div class="about">
            <p><?php echo $row['sazetak']; ?></p>
        </div>

        <div class="content">
            <p><?php echo $row['tekst']; ?></p>
        </div>

        <br>
        <p><a href="index.php">← Natrag na naslovnicu</a></p>

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