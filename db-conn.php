<?php 

$hostname = "localhost";
$username = "root";
$password = "";

$conn = @mysqli_connect($hostname, $username, $password) or die("A conexão com o Banco de Dados falhou: " . mysqli_connect_error());

$conn->set_charset('utf8');


?>