<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

include 'conexion.php';

$productos = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrador</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>Panel Administrador</h1>

    <div class="menu">
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</header>

<div class="formulario">

<form action="guardar_producto.php" method="POST" enctype="multipart/form-data">

<input type="text" name="nombre" placeholder="Nombre" required>

<select name="categoria">
    <option>Damas</option>
    <option>Caballeros</option>
    <option>Niños</option>
</select>

<textarea name="descripcion" placeholder="Descripción"></textarea>

<input type="number" step="0.01" name="precio" placeholder="Precio">

<input type="file" name="imagen" required>

<button class="btn">Guardar Producto</button>

</form>

</div>

<div class="contenedor">

<?php while($row = $productos->fetch_assoc()){ ?>

<div class="card">

<img src="uploads/<?php echo $row['imagen']; ?>">

<div class="card-body">

<h2><?php echo $row['nombre']; ?></h2>

<p><?php echo $row['descripcion']; ?></p>

<a class="btn" href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>

<a class="btn" href="eliminar.php?id=<?php echo $row['id']; ?>">Eliminar</a>

</div>
</div>

<?php } ?>

</div>

</body>
</html>