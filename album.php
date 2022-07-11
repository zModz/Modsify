<?php 
//session_start();
include("includes/webpage/funcs.php");

$a = new Album;
$s = new Songs;

$res = $a->listarAlbumInfo();
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
                echo '<h1 style="color: white;">MUSICAS</h1>';
                $s->mostrarSongs($res2);
            ?>
        </div>
    </div>
</body>
</html>