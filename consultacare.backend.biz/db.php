<?php
$servername = "database";
$username = "ifrn"; 
$password = "ifrn"; 
$dbname = "consultacare"; 

// Criando a conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificando a conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>