<?php 
session_start();
require_once("includes/webpage/funcs.php");

if(!isset($_SESSION["user"])){
  header("erro.php");
}

$m = new Songs;
$al = new Album;
$ar = new Artista;
$resAl = $al->listarAlbums();
$resAr = $ar->ListarArtista();

// sql insert inserts the things to insert
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["Stitulo"])){  
    $res = $m->addSong();
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
        <h1 class="pageTitle">INSERIR</h1>
        <form action="" method="post">
          <table id="formTab">
            <tr>
              <td>Titulo da Musica: </td>
              <td><input type="text" name="Stitulo" required> </td>
            </tr>
            <tr>
              <td>Album: </td>
              <td>
                <select name="albumDrop" id="dropAlbum">
                  <?php 
                    foreach($resAl as $row){
                      echo '<option value="'.$row["id_al"].'">'.$row["nome_al"].'</option>';
                    }
                  ?>
                </select> 
              </td>
            </tr>
            <tr>
              <td>Artista(s): </td>
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
              <td> </td>
              <td><input type="submit" value="Adicionar"> </td>
            </tr>
          </table>
        </form>
    </div>
    <!-- FOOTER -->
    <?php #include("includes/webpage/footer.php") ?>
</body>
</html>