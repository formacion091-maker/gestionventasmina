<?php
include 'conexion.php';

$id = $_GET['id'];

$producto = $conn->query("SELECT * FROM productos WHERE id=$id");
$row = $producto->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="formulario">

<form action="actualizar.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="text" name="nombre" value="<?php echo $row['nombre']; ?>">

<textarea name="descripcion"><?php echo $row['descripcion']; ?></textarea>

<input type="number" name="precio" value="<?php echo $row['precio']; ?>">

<button class="btn">Actualizar</button>

</form>

</div>

</body>
</html>