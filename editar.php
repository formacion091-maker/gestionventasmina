<?php
include 'conexion.php';
include 'helpers.php';

$id = (int)$_GET['id'];

$producto = $conn->query("SELECT * FROM productos WHERE id=$id");
$row = $producto->fetch_assoc();
$categoria = normalizar_categoria($row['categoria']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
    <h1>Editar Producto</h1>
    <div class="menu">
        <a href="admin.php">Volver</a>
    </div>
</header>

<div class="formulario">
    <form action="actualizar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">

        <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>

        <select name="categoria">
            <option <?php echo $categoria === 'Hombres' ? 'selected' : ''; ?>>Hombres</option>
            <option <?php echo $categoria === 'Mujeres' ? 'selected' : ''; ?>>Mujeres</option>
            <option value="Ninos" <?php echo $categoria === 'Ninos' ? 'selected' : ''; ?>>Ni&ntilde;os</option>
        </select>

        <textarea name="descripcion"><?php echo htmlspecialchars($row['descripcion']); ?></textarea>
        <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>">

        <button class="btn">Actualizar</button>
    </form>
</div>

</body>
</html>
