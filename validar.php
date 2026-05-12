<?php
session_start();

$usuario = $_POST['usuario'];
$password = $_POST['password'];

if($usuario === 'mina' && $password === '1234'){
    $_SESSION['admin'] = $usuario;
    header("Location: admin.php");
    exit;
}

echo "Datos incorrectos";
?>
