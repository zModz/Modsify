<?php 
    require_once("includes/webpage/funcs.php");
    $msgLog = "";
    $error = 0;
    $u = new User;
    
    /* verificar se estamos a receber os dados do formulario */
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["fuser"])){
        $error = $u->login();    
    }    
?>

<!DOCTYPE html>
<html>
    <body class="dark">
    <?php
        if(isset($_SESSION['user'])){
            $user=$_SESSION['user'];
            $msgLog = "<p class='text'>Benvindo $user - <a href='logout.php'>logout</a></p>";
            echo $msgLog;
        }
        else{
    ?>
        <form method="POST" action="">
        <table id="logTab">
            <tr>
                <td>
                    <input type="text" placeholder="Username" class="logInput" name="fuser"';
                    <?php if($error == "2"){ echo 'style="border:1px solid red;"'; } ?> required>
                </td>
                <td>
                    <input type="password" placeholder="Password" class="logInput" name="fpass"';
                    <?php if($error == "1"){ echo 'style="border:1px solid red;"'; } ?> required>
                </td>
                <td>
                    <input type="submit" value="Login">
                </td>
                <td>
                    <a href="loginRegister_2.php">Register</a>
                </td>
            </tr>
        </table>
        </form>
    <?php
        }
    ?>
    </body>
</html>