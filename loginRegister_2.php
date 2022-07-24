<?php 
    require_once("includes/webpage/funcs.php");
    $msgLog = "";
    $u = new User;
    
    /* verificar se estamos a receber os dados do formulario */
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["fuser"])){
        $msgLog = $u->adduser($_POST["fuser"]);    
    }    
?>

<!DOCTYPE html>
<html>
    <?php include("includes/webpage/head.php"); ?>
    <body>
        <?php include("includes/webpage/navbar.php") ?>
        <div id="content">
        <div class="space">&nbsp;</div>
        <h1 class="pageTitle">REGISTER</h1>
            <form method="POST" action="">
                <table id="formTab">
                    <tr>
                        <td>Username: </td>
                        <td><input type="text" class="logInput" name="fuser" required></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" class="logInput" name="fpass" required></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td><input type="submit" value="Register"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>