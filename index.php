<?php 
    include("includes/webpage/funcs.php");
    session_start();

    $u = new User;

    $a = new Album;
    $res = $a->listarAlbumsHOME();

    $ar = new Artista;
    $resAr = $ar->listarArtistaHOME();
    
    $m = new Songs;
    $resM = $m->listarSongsAllHOME();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">BEM-VINDO DE VOLTA!</h1>
        <div class="musicDisplay">
            <?php 
                $a->mostrarAlbuns($res);
            ?>
        </div>
        <h1 class="pageTitle">ARTISTAS POPULARES</h1>
        <div class="artistDisplay">
            <?php
                $ar->mostrarArtista($resAr);
            ?>
        </div>
        <h1 class="pageTitle">MUSICAS POPULARES</h1>
        <div class="musicDisplay">
            <?php 
                $m->mostrarSongsAll($resM);
            ?>
        </div>
    </div>
    <?php
        // include("includes/webpage/footer.php");
    ?>
</body>
</html>