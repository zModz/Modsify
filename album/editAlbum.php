<?php 
session_start();
require_once("includes/db/db_conn.php");

// sql go BRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["Mtitulo"])){  
    $titulo = $_POST["Mtitulo"]; 
    $artista = $_POST["Martist"]; 
    $album = $_POST["Malbum"]; 
    $ano = $_POST["Mano"];
    $ida = $_GET['ida'];
  
    $sql = "UPDATE album SET nome_al='$titulo',ano_al='$ano' WHERE id_al = '$ida'";
    $result = $conn -> query($sql);
  
    if($result === TRUE){
      $fdb = 1;
      header('location: album.php?ida='.$ida.'&alerta='.$fdb);
    }
    else {
      $fdb = 0;
      header("location: erro.php?alerta=".$fdb);
    }
}elseif(isset($_GET['ida'])){
  // get id
  $ida = $_GET['ida'];
  $sqlUp = "SELECT * FROM album WHERE id_al = '$ida'";

  $res = mysqli_query($conn, $sqlUp);
  $row = mysqli_fetch_array($res);

  $tituloM = $row["nome_al"];
  $anoM = $row["ano_al"];
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
        <form action="" method="post">
          <table id="formTab">
            <tr>
              <td>Titulo do album: </td>
              <td><input type="text" name="Mtitulo" value="<?=$tituloM ?>" required> </td>
            </tr>
            <tr>
              <td>Ano de lançamento: </td>
              <td><input type="number" name="Mano" value="<?=$anoM ?>" required> </td>
            </tr>
            <tr>
              <td> </td>
              <td><input type="submit" value="Atualizar"> </td>
            </tr>
          </table>
        </form>
    </div>
    <!-- FOOTER -->
    <?php include("includes/webpage/footer.php") ?>
</body>
</html>