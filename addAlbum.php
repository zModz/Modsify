<?php 
session_start();
require_once("includes/webpage/funcs.php");

if(!isset($_SESSION["user"])){
  header("erro.php");
}


$a = new Album;
$ar = new Artista;
$g = new Generos;
$resAr = $ar->listarArtista();
$resG = $g->listarGeneros();
/* verificar se estamos a receber os dados do formulario */
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["Mtitulo"])){
  $res = $a->addAlbum();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/head.php"); ?>
<body class="dark">
  <?php include("includes/webpage/navbar.php") ?>
    <!-- CONTENT -->
    <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">INSERIR</h1>
        <form action="" method="post" enctype="multipart/form-data">
          <table id="formTab">
          <tr>
              <td>Artista do album: </td>
              <td>
                <select name="artistDrop" id="dropArtist">
                  <?php 
                    foreach($resAr as $row){
                      echo '<option value="'.$row["id_a"].'">'.$row["nome_a"].'</option>';
                    }
                  ?>
                </select> 
              </td>
            </tr>
            <tr>
              <td>Titulo do album: </td>
              <td><input type="text" name="Mtitulo" required> </td>
            </tr>
            <tr>
              <td>Ano de lançamento: </td>
              <td><input type="number" name="Aano" required> </td>
            </tr>
            <tr>
              <td>Capa do album: </td>
              <td><input type="file" name="cover" required> </td>
            </tr>
            <tr>
              <td>Genero: </td>
              <td>
                <select name="generoDrop" id="dropGenero" required>
                  <?php 
                    foreach($resG as $row){
                      echo '<option value="'.$row["id_g"].'">'.$row["nome_g"].'</option>';
                    }
                  ?>
                </select> 
              </td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" value="Adicionar"> </td>
            </tr>
          </table>
        </form>
    </div>
</body>
</html>
<?php $a->fechaConn(); ?>