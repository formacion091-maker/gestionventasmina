<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include 'conexion.php';
include 'helpers.php';

$productos = $conn ? $conn->query("SELECT * FROM productos ORDER BY categoria, nombre") : false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
    <h1>Panel Administrador</h1>

    <div class="menu">
        <a href="index.php">Ver tienda</a>
        <a href="logout.php">Cerrar Sesi&oacute;n</a>
    </div>
</header>

<div class="formulario">
    <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre" required>

        <select name="categoria">
            <option>Hombres</option>
            <option>Mujeres</option>
            <option value="Ninos">Ni&ntilde;os</option>
        </select>

        <textarea name="descripcion" placeholder="Descripci&oacute;n"></textarea>
        <input type="number" step="0.01" name="precio" placeholder="Precio">
        <input type="file" name="imagen" accept="image/*" required>

        <button class="btn">Guardar Producto</button>
    </form>
</div>

<div class="contenedor">
    <?php if(!$productos){ ?>
        <div class="card card-vacia">
            <div class="card-body">
                <h2>Base de datos no conectada</h2>
                <p>Revisa la conexi&oacute;n para poder ver y guardar productos del administrador.</p>
            </div>
        </div>
    <?php } ?>

    <?php while($productos && $row = $productos->fetch_assoc()){ ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars(ruta_imagen_producto($row['imagen'], $row['categoria'])); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">

            <div class="card-body">
                <span class="etiqueta"><?php echo nombre_categoria($row['categoria']); ?></span>
                <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>

                <a class="btn" href="editar.php?id=<?php echo (int)$row['id']; ?>">Editar</a>
                <a class="btn btn-peligro" href="eliminar.php?id=<?php echo (int)$row['id']; ?>">Eliminar</a>
            </div>
        </div>
    <?php } ?>
</div>

</body>
</html>
