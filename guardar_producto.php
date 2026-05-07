<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

$imagen = $_FILES['imagen']['name'];
$temp = $_FILES['imagen']['tmp_name'];

move_uploaded_file($temp, "uploads/".$imagen);

$sql = "INSERT INTO productos(nombre,categoria,descripcion,precio,imagen)
VALUES('$nombre','$categoria','$descripcion','$precio','$imagen')";

$conn->query($sql);

header("Location: admin.php");
?>