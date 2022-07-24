<?php 
session_start();
include("includes/webpage/funcs.php");

$a = new Artista;

$res = $a->listarArtista();

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">ARTISTAS</h1>
        <div class="musicDisplay">
            <?php 
                $a->mostrarArtista($res);
            ?>
        </div>
    </div>
</body>
</html>