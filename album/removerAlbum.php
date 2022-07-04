<?php 
session_start();
require_once("includes/db/db_conn.php");

// checks se existe um alerta
if(isset($_GET["alerta"])){
    $msgAlerta = "<p class='alertas'>SUCESSO!</p>";
}
else{
    $msgAlerta = "";
}

// checks se existe id, remove comforme esse id
if(isset($_GET['ida'])){
    $ida = $_GET['ida'];
    $sqlrm = "DELETE FROM album WHERE id_al = '$ida'";
    $res = $conn -> query($sqlrm);
    
    if($res === true){
        $fdb = 1;
        header("location: index.php?alerta=".$fdb);
    }
    else{
        $fdb = 0;
        header("location: erro.php?alerta=".$fdb);  
    }
}