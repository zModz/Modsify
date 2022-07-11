<?php 
session_start();
require_once("includes/webpage/funcs.php");

$a = new Album;

/* verificar se estamos a receber os dados do formulario */
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["fcidade"])){
  $a->editarAlbum();    
}elseif(isset($_GET['idc'])){   // verificar se estou a receber um id no URL 
  $dados = $a->formEditar();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/webpage/head.php"); ?>
<body>
    <!-- CONTENT -->
    <div id="content">
        <form action="" method="post">
          <table id="formTab">
            <tr>
              <td>Titulo do album: </td>
              <td><input type="text" name="Mtitulo" value="<?=$dados["nome"] ?>" required> </td>
            </tr>
            <tr>
              <td>Ano de lançamento: </td>
              <td><input type="number" name="Mano" value="<?=$dados["ano"] ?>" required> </td>
            </tr>
            <tr>
              <td> </td>
              <td><input type="submit" value="Atualizar"> </td>
            </tr>
          </table>
        </form>
    </div>
</body>
</html>