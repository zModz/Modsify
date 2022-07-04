<?php 
// require_once("includes/db/db_conn.php");
include("includes/webpage/funcs.php");

$a = new Album;
$res = $a->listarAlbum();

?>
<!DOCTYPE html>
<html lang="en">
<body>
    <!-- CONTENT -->
    <div id="content">
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