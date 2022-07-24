<?php 
    include("includes/webpage/funcs.php");
    session_start();

    $u = new User;

    $a = new Album;
    $ar = new Artista;
    $m = new Songs;

    $pesq = new Search;
    $resAl = $pesq->searchResultsAlbum();
    $resAr = $pesq->searchResultsArtista();
    $resMu = $pesq->searchResultsSong();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">ALBUMS</h1>
        <div class="musicDisplay">
            <?php 
                $a->mostrarAlbumCard($resAl);
            ?>
        </div>
        <h1 class="pageTitle">ARTISTAS</h1>
        <div class="artistDisplay">
            <?php
                $ar->mostrarArtista($resAr);
            ?>
        </div>
        <h1 class="pageTitle">MUSICAS</h1>
        <div class="musicDisplay">
            <?php 
                $m->mostrarSongsAll($resMu);
            ?>
        </div>
    </div>
    <?php
        // include("includes/webpage/footer.php");
    ?>
</body>
</html>