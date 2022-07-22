<?php
session_start();
	
// tornar NULL o conteúdo das variáveis
$_SESSION['user'] = NULL;
$_SESSION['nivel'] = NULL;

// apagar as variáveis
unset($_SESSION['user']);
unset($_SESSION['nivel']);

// "destruir" a sessão
session_destroy();

if(file_exists("index.php")){
    header("location: index.php");
}
?>