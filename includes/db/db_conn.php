<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "projectmusic";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($conn -> connect_error){
    die("Connection Failed " . $conn->connect_error);
}

// echo "Connection Successfull!";
?>