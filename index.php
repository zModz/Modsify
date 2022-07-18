<?php 
    include("includes/webpage/funcs.php");

    $a = new Album;
    $res = $a->listarAlbum();

    $ar = new Artista;
    $resAr = $ar->ListarArtista();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div style="height: 60px; width: 100%;">&nbsp;</div>
        <h1 class="pageTitle">BEM-VINDO DE VOLTA, USER</h1>
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
    </div>
    <?php
        include("includes/webpage/footer.php");
    ?>
</body>
</html>