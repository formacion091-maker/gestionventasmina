<?php
include 'conexion.php';

$sql = "SELECT carrito.id, productos.nombre, productos.precio
FROM carrito
INNER JOIN productos
ON carrito.producto_id = productos.id";

$datos = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
<h1>Carrito de Compras</h1>
</header>

<div class="contenedor">

<?php while($row = $datos->fetch_assoc()){ ?>

<div class="card">
<div class="card-body">

<h2><?php echo $row['nombre']; ?></h2>

<h3>$<?php echo $row['precio']; ?></h3>

</div>
</div>

<?php } ?>

</div>

</body>
</html>