<?php
    // Dohvaćamo podatke iz forme
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    } else {
        $title = '';
    }

    if (isset($_POST['about'])) {
        $about = $_POST['about'];
    } else {
        $about = '';
    }

    if (isset($_POST['content'])) {
        $content = $_POST['content'];
    } else {
        $content = '';
    }

    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    } else {
        $category = '';
    }

    // Provjera arhive - checkbox
    if (isset($_POST['archive'])) {
        $archive = 'Da - vijest je arhivirana';
    } else {
        $archive = 'Ne - vijest je vidljiva';
    }

    // Dohvaćamo ime slike
    if (isset($_FILES['pphoto']['name']) && $_FILES['pphoto']['name'] != '') {
        $image = $_FILES['pphoto']['name'];
        // Premještamo sliku u img/ mapu
        $target = 'img/' . $image;
        move_uploaded_file($_FILES['pphoto']['tmp_name'], $target);
    } else {
        $image = '';
    }
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC News – <?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-inner">
        <div class="bbc-logo">BBC</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="kategorija.php?id=news">News</a></li>
                <li><a href="kategorija.php?id=sport">Sport</a></li>
                <li><a href="unos.html">Unos</a></li>
                <li><a href="administrator.php">Administracija</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- ŽUTA TRAKA S KATEGORIJOM -->
<div class="category-bar">
    <h2><?php echo strtoupper($category); ?></h2>
</div>

<!-- SADRŽAJ ČLANKA -->
<main>
    <div class="article-detail">

        <!-- NASLOV -->
        <h1><?php echo $title; ?></h1>

        <p><strong>AUTOR:</strong> Nepoznat</p>
        <p><strong>OBJAVLJENO:</strong> <?php echo date('d.m.Y.'); ?></p>
        <p><strong>Arhiva:</strong> <?php echo $archive; ?></p>

        <br>

        <!-- SLIKA -->
        <?php if ($image != '') { ?>
            <img 
                src="img/<?php echo $image; ?>" 
                alt="<?php echo $title; ?>"
                class="article-image"
            >
        <?php } ?>

        <!-- KRATKI SAŽETAK -->
        <div class="about">
            <p><?php echo $about; ?></p>
        </div>

        <!-- PUNI TEKST -->
        <div class="content">
            <p><?php echo $content; ?></p>
        </div>

        <!-- LINK NATRAG -->
        <br>
        <p><a href="unos.html">← Unesi novu vijest</a></p>
        <p><a href="index.html">← Natrag na naslovnicu</a></p>

    </div>
</main>

<!-- FOOTER -->
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