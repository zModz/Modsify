<?php 
session_start();
include("includes/webpage/funcs.php");

$a = new Album;
$s = new Songs;

$res = $a->listarAlbumInfo();
$res2 = $s->listarSongsAlbum();

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div style="height: 60px; width: 100%;">&nbsp;</div>
        <div class="albumPage">
            <?php
                $a->mostrarInfo($res);
                echo '<h1 style="color: var(--text-color);">MUSICAS</h1>';
                $s->mostrarSongs($res2);
            ?>
        </div>
    </div>
</body>
</html>