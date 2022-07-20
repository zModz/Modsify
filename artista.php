<?php 
session_start();
include("includes/webpage/funcs.php");

$ar = new Artista;
$a = new Album;

$resAr = $ar->ListarArtistaInfo();
$res = $a->listarAlbumArtista();

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/head.php"); ?>
<body class="dark">
    <!-- NAV -->
    <?php include("includes/webpage/navbar.php") ?>
    <!-- CONTENT -->
    <div id="content">
        <?php print_r($res); ?>
        <div style="height: 60px; width: 100%;">&nbsp;</div>
        <div class="albumPage">
            <?php $ar->mostrarInfoArtista($resAr); ?>
            <h1 style="color: var(--text-color);">ALBUMS</h1>
            <div class="albumDisplay">
                <?php $a->mostrarAlbumCard($res); ?>
            </div>
            <h1 style="color: var(--text-color);">MUSICAS</h1>
        </div>
    </div>
</body>
</html>