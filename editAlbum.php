<?php 
session_start();
require_once("includes/webpage/funcs.php");

$a = new Album;

/* verificar se estamos a receber os dados do formulario */
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["Mtitulo"])){
  $a->editarAlbum();    
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/head.php"); ?>
<body>
    <!-- CONTENT -->
    <div id="content">
      <div style="height: 60px; width: 100%;">&nbsp;</div>
      <?php
        if(isset($_GET['ida'])){   // verificar se estou a receber um id no URL 
          $dados = $a->formEditar();
        }
      ?>
    </div>
</body>
</html>