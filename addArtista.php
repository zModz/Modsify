<?php 
session_start();
include("includes/webpage/funcs.php");

// if(!$_SESSION["user"]){
//   header("erro.php");
// }

$ar = new Artista;


// sql insert inserts the things to insert
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["arNome"])){  
  $res = $ar->addArtista();
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
              <td>Nome do Artista: </td>
              <td><input type="text" name="arNome" required> </td>
            </tr>
            <tr>
              <td>Imagem do artista: </td>
              <td><input type="file" name="img"> </td>
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