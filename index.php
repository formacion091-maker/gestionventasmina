<?php
include 'conexion.php';
include 'helpers.php';

$productos = $conn->query("SELECT * FROM productos ORDER BY categoria, nombre");
$secciones = [
    'Hombres' => [],
    'Mujeres' => [],
    'Ninos' => []
];

while($row = $productos->fetch_assoc()){
    $categoria = normalizar_categoria($row['categoria']);
    $secciones[$categoria][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Ropa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="hero">
    <div class="hero-contenido">
        <h1>Tienda Fashion Style</h1>

        <div class="menu">
            <a href="index.php">Inicio</a>
            <a href="carrito.php">Carrito</a>
            <a href="login.php">Administrador</a>
        </div>

        <p>Moda para hombres, mujeres y ni&ntilde;os.</p>
    </div>
</header>

<main>
    <?php foreach($secciones as $titulo => $items){ ?>
        <section class="seccion-categoria seccion-<?php echo carpeta_categoria($titulo); ?>">
            <div class="titulo-seccion">
                <h2><?php echo nombre_categoria($titulo); ?></h2>
                <p><?php echo count($items); ?> productos disponibles</p>
            </div>

            <div class="contenedor">
                <?php if(count($items) === 0){ ?>
                    <div class="card card-vacia">
                        <div class="card-body">
                            <h3>Sin productos por ahora</h3>
                            <p>Agrega productos desde el panel administrador para llenar esta secci&oacute;n.</p>
                        </div>
                    </div>
                <?php } ?>

                <?php foreach($items as $row){ ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars(ruta_imagen_producto($row['imagen'], $row['categoria'])); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">

                        <div class="card-body">
                            <span class="etiqueta"><?php echo nombre_categoria($row['categoria']); ?></span>
                            <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                            <strong>$<?php echo number_format((float)$row['precio'], 2); ?></strong>

                            <a class="btn" href="agregar_carrito.php?id=<?php echo (int)$row['id']; ?>">
                                Agregar al carrito
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
</main>

<footer>
    <h3>Fashion Style 2026</h3>
</footer>

</body>
</html>
