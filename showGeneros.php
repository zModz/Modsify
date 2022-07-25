<?php 
session_start();
include("includes/webpage/funcs.php");

$g = new Generos;

$res = $g->listarGeneros();

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">GENEROS</h1>
        <div class="musicDisplay">
            <?php 
                $g->mostrarGeneros($res);
            ?>
        </div>
    </div>
</body>
</html>