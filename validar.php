<?php
session_start();
include 'conexion.php';

$usuario = $_POST['usuario'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){
    $_SESSION['admin'] = $usuario;
    header("Location: admin.php");
}else{
    echo "Datos incorrectos";
}
?>
