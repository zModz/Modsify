<?php 
//session_start();
include("../includes/webpage/funcs.php");

$a = new Album;
$res = $a->listarAlbumInfo();

$s = new Songs;
$res2 = $s->listarSongs();
?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body>
    <!-- CONTENT -->
    <div id="content">
        <div class="albumPage">
            <?php
                $a->mostrarInfo($res);
                $s->mostrarSongs($res2);
            ?>
        </div>
    </div>
</body>
</html>