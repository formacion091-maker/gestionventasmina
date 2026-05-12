<?php
include 'conexion.php';
include 'helpers.php';

$sql = "SELECT carrito.id, productos.nombre, productos.precio, productos.categoria, productos.imagen
FROM carrito
INNER JOIN productos
ON carrito.producto_id = productos.id";

$datos = $conn ? $conn->query($sql) : false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
    <h1>Carrito de Compras</h1>
    <div class="menu">
        <a href="index.php">Seguir comprando</a>
    </div>
</header>

<div class="contenedor">
    <?php if(!$datos){ ?>
        <div class="card card-vacia">
            <div class="card-body">
                <h2>Carrito no disponible</h2>
                <p>Revisa la conexi&oacute;n con la base de datos.</p>
            </div>
        </div>
    <?php } ?>

    <?php while($datos && $row = $datos->fetch_assoc()){ ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars(ruta_imagen_producto($row['imagen'], $row['categoria'])); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
            <div class="card-body">
                <span class="etiqueta"><?php echo nombre_categoria($row['categoria']); ?></span>
                <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                <h3>$<?php echo number_format((float)$row['precio'], 2); ?></h3>
            </div>
        </div>
    <?php } ?>
</div>

</body>
</html>
