<?php 
session_start();
include("includes/webpage/funcs.php");

$a = new Album;

$res = $a->listarAlbums();

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
                $a->mostrarAlbumCard($res);
            ?>
        </div>
    </div>
</body>
</html>