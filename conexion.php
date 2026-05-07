<?php
$host = "mysql-mina.alwaysdata.net";
$user = "mina";
$pass = "clase12";
$db = "mina_gestionventasmina";

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Error de conexión: " . $conn->connect_error);
}
?>