<?php 
session_start();
include("includes/webpage/funcs.php");

if(!$_SESSION["user"]){
  header("erro.php");
}

$g = new Generos;


// sql insert inserts the things to insert
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["gNome"])){  
  $res = $ar->editarGeneros();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/head.php"); ?>
<body class="dark">
  <!-- NAV -->
    <?php include("includes/webpage/navbar.php") ?>
    <!-- CONTENT -->
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">EDITAR</h1>
        <?php 
            $g->formEditar();
        ?>
    </div>
    <!-- FOOTER -->
    <!-- <?php include("includes/webpage/footer.php") ?> -->
</body>
</html>