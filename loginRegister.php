<?php 
    require_once("includes/webpage/funcs.php");
    $msgLog = "";
    $a = new User;
    
    /* verificar se estamos a receber os dados do formulario */
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["fuser"])){
        $msgLog = $a->login();    
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
                        <input type="submit" value="login">
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><?php echo $msgLog ?></td>
                </tr>
            </table>
        </form>
    </body>
</html>