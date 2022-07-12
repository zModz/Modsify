<?php 
    include("includes/webpage/funcs.php");

    $a = new Album;
    $res = $a->listarAlbum();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div style="height: 60px; width: 100%;">&nbsp;</div>
        <?php include("includes/webpage/navTab.php") ?> 
        <h1 class="pageTitle">HOME</h1>
        <div class="musicDisplay">
            <?php 
                $a->mostrarAlbuns($res);
            ?>
        </div>
    </div>
</body>
</html>