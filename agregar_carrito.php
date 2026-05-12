<?php
include 'conexion.php';

$id = (int)$_GET['id'];

$conn->query("INSERT INTO carrito(producto_id,cantidad)
VALUES($id,1)");

header("Location: carrito.php");
?>
