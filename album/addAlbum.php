<?php 
session_start();
require_once("includes/db/db_conn.php");

if(!$_SESSION["user"]){
  header("erro.php");
}


// sql insert inserts the things to insert
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["Mtitulo"])){  
    $titulo = $_POST["Mtitulo"]; 
    $ano = $_POST["Aano"]; 
    $idAl = $_GET["ida"];
    $FileNewName = $titulo;
    require 'includes/webpage/upload.inc.php';
  
    $sql = "INSERT INTO album (nome_al, ano_al) VALUES ('$titulo', '$ano')";
    $result = $conn -> query($sql);
  
    if($result === TRUE){
      $fdb = 1;
      header("location: index.php?alerta=".$fdb);
    }
    else {
      $fdb = 0;
      header("location: erro.php?alerta=".$fdb);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/header.php"); ?>
<body>
  <!-- NAV -->
    <?php include("includes/webpage/nav.php") ?>
    <!-- CONTENT -->
    <div id="content">
        <h1 class="pageTitle">INSERIR</h1>
        <form action="" method="post">
          <table id="formTab">
            <tr>
              <td>Titulo do album: </td>
              <td><input type="text" name="Mtitulo" required> </td>
            </tr>
            <tr>
              <td>Ano de lançamento: </td>
              <td><input type="text" name="Aano" required> </td>
            </tr>
            <tr>
              <td>Capa do album: </td>
              <td><input type="file" name="cover"> </td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" value="Adicionar"> </td>
            </tr>
          </table>
        </form>
    </div>
    <!-- FOOTER -->
    <?php include("includes/webpage/footer.php") ?>
</body>
</html>