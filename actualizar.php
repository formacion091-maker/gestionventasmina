<?php
include 'conexion.php';
include 'helpers.php';

if(!$conn){
    die("No hay conexion con la base de datos.");
}

$id = (int)$_POST['id'];
$nombre = $_POST['nombre'];
$categoria = normalizar_categoria($_POST['categoria']);
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

$sql = "UPDATE productos SET nombre=?, categoria=?, descripcion=?, precio=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdi", $nombre, $categoria, $descripcion, $precio, $id);
$stmt->execute();

header("Location: admin.php");
?>
