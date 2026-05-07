<?php
include 'conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

$sql = "UPDATE productos SET
nombre='$nombre',
descripcion='$descripcion',
precio='$precio'
WHERE id=$id";

$conn->query($sql);

header("Location: admin.php");
?>