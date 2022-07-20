<?php 
session_start();
require_once("includes/db/db_conn.php");

// sql go BRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST["Mtitulo"])){  
    $titulo = $_POST["Mtitulo"];
    $ida = $_GET['ida'];
  
    $sql = "UPDATE artista SET nome_a='$titulo' WHERE id_a = '$ida'";
    $result = $conn -> query($sql);
  
    if($result === TRUE){
      $fdb = 1;
      header('location: artista.php?ida='.$ida.'&alerta='.$fdb);
    }
    else {
      $fdb = 0;
      header("location: erro.php?alerta=".$fdb);
    }
}elseif(isset($_GET['ida'])){
  // get id
  $ida = $_GET['ida'];
  $sqlUp = "SELECT * FROM artista
              WHERE id_a = '$ida'";

  $res = mysqli_query($conn, $sqlUp);
  $row = mysqli_fetch_array($res);

  $tituloM = $row["nome_a"];
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
              <td>Nome do Artista: </td>
              <td><input type="text" name="Mtitulo" value="<?=$tituloM ?>" required> </td>
            </tr>
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