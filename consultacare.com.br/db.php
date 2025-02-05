<?php
$servername = "database";
$username = "ifrn"; 
$password = "ifrn"; 
$dbname = "consultacare"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>