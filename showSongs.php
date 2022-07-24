<?php 
session_start();
include("includes/webpage/funcs.php");

$a = new Songs;

$res = $a->listarSongsAll();

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">SONGS</h1>
        <div class="musicDisplay">
            <?php 
                $a->mostrarSongsAll($res);
            ?>
        </div>
    </div>
</body>
</html>