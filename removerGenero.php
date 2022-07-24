<?php 
session_start();
require_once("includes/webpage/funcs.php");

$m = new Generos;

// checks se existe id, remove comforme esse id
if(isset($_GET['idm']) && isset($_GET["ida"])){
    $m->removerGenero();
}
?>