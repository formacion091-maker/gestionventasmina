<?php
include 'conexion.php';
include 'helpers.php';

$id = (int)$_GET['id'];
$telefono = '573232825032';

$stmt = $conn->prepare("SELECT id, nombre, categoria, descripcion, precio FROM productos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if(!$producto){
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("INSERT INTO carrito(producto_id,cantidad) VALUES(?,1)");
$stmt->bind_param("i", $id);
$stmt->execute();

$categoria = html_entity_decode(strip_tags(nombre_categoria($producto['categoria'])), ENT_QUOTES, 'UTF-8');
$mensaje = "Hola, escogieron este producto en la tienda:\n";
$mensaje .= "Producto: ".$producto['nombre']."\n";
$mensaje .= "Categoria: ".$categoria."\n";
$mensaje .= "Precio: $".number_format((float)$producto['precio'], 2)."\n";
$mensaje .= "Descripcion: ".$producto['descripcion']."\n";
$mensaje .= "ID: ".$producto['id'];

header("Location: https://wa.me/$telefono?text=".rawurlencode($mensaje));
exit;
?>
