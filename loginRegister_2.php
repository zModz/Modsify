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
    <body>
        <form method="POST" action="">
            <table id="logTab">
                <tr>
                    <td>
                        <input type="text" class="logInput" name="fuser" required>
                    </td>
                    <td>
                        <input type="password" class="logInput" name="fpass" required>
                    </td>
                    <td>
                        <input type="submit" value="register">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>