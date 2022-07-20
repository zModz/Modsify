<?php 
session_start();
require_once("includes/webpage/funcs.php");

$a = new Album;

// checks se existe id, remove comforme esse id
if(isset($_GET['ida'])){
    $a->removerAlbum();
}