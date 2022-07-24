<?php 
session_start();
include("includes/webpage/funcs.php");

if(!$_SESSION["user"]){
  header("erro.php");
}

$g = new Generos;


// sql insert inserts the things to insert
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["gNome"])){  
  $res = $g->addGeneros();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/head.php"); ?>
<body>
  <!-- NAV -->
    <?php include("includes/webpage/navbar.php") ?>
    <!-- CONTENT -->
    <div id="content">
        <div style="height: 60px; width: 100%;">&nbsp;</div>
        <h1 class="pageTitle">INSERIR</h1>
        <form action="" method="post" enctype="multipart/form-data">
          <table id="formTab">
            <tr>
              <td>Nome do Genero: </td>
              <td><input type="text" name="gNome" required> </td>
            </tr>
            <tr>
              <td> </td>
              <td><input type="submit" value="Adicionar"> </td>
            </tr>
          </table>
        </form>
    </div>
    <!-- FOOTER -->
    <!-- <?php include("includes/webpage/footer.php") ?> -->
</body>
</html>