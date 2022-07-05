<?php 
session_start();
require_once("../includes/webpage/funcs.php");

// if(!$_SESSION["user"]){
//   header("erro.php");
// }

$a = new Album;
/* verificar se estamos a receber os dados do formulario */
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["Mtitulo"])){
  $res = $a->addAlbum();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("../includes/webpage/head.php"); ?>
<body>
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
</body>
</html>
<?php $a->fechaConn(); ?>