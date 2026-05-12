<?php
include 'conexion.php';

$id = (int)$_GET['id'];

$conn->query("DELETE FROM productos WHERE id=$id");

header("Location: admin.php");
?>
