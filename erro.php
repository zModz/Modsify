<?php 
session_start();
include("includes/webpage/funcs.php");


?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php"); ?>
<body class="dark">
    <?php include("includes/webpage/navbar.php") ?>
    <div id="content">
        <div class="space">&nbsp;</div>
        <a style="width: 99%;" href="index.php"><- Voltar a paginal inicial</a>
        <h1 style="color: red;" class="pageTitle">ERROR</h1>
            <?php
                errorGen($_GET["alerta"]);
            ?>
    </div>
</body>
</html>