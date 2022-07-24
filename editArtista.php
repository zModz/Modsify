<?php 
session_start();
require_once("includes/webpage/funcs.php");

$a = New Artista;

// sql go BRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["arNome"])){  
    $a->editarArtista();
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
        if(isset($_GET['ida'])){   // verificar se estou a receber um id no URL 
          $dados = $a->formEditar();
        }
      ?>
    </div>
    <!-- FOOTER -->
    <?php #include("includes/webpage/footer.php") ?>
</body>
</html>