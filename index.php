<?php
include 'conexion.php';
$productos = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tienda de Ropa</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>Tienda Fashion Style</h1>

    <div class="menu">
        <a href="index.php">Inicio</a>
        <a href="carrito.php">Carrito</a>
        <a href="login.php">Administrador</a>
    </div>
</header>

<section style="padding:40px;text-align:center;">
    <h2>Moda para Damas, Caballeros y Niños</h2>
    <p>Explora nuestros productos modernos y dinámicos.</p>
</section>

<div class="contenedor">

<?php while($row = $productos->fetch_assoc()){ ?>

<div class="card">
    <img src="uploads/<?php echo $row['imagen']; ?>">

    <div class="card-body">
        <h2><?php echo $row['nombre']; ?></h2>

        <p><?php echo $row['descripcion']; ?></p>

        <h3>$<?php echo $row['precio']; ?></h3>

        <a class="btn" href="agregar_carrito.php?id=<?php echo $row['id']; ?>">
            Agregar al carrito
        </a>
    </div>
</div>

<?php } ?>

</div>

<footer>
    <h3>Fashion Style 2026</h3>
</footer>

</body>
</html>