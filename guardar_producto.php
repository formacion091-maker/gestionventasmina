<?php
include 'conexion.php';
include 'helpers.php';

$nombre = $_POST['nombre'];
$categoria = normalizar_categoria($_POST['categoria']);
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

$imagen_original = basename($_FILES['imagen']['name']);
$extension = pathinfo($imagen_original, PATHINFO_EXTENSION);
$nombre_base = pathinfo($imagen_original, PATHINFO_FILENAME);
$nombre_base = preg_replace('/[^a-zA-Z0-9_-]/', '-', $nombre_base);
$imagen = $nombre_base.'-'.time().'.'.$extension;
$temp = $_FILES['imagen']['tmp_name'];
$carpeta = carpeta_categoria($categoria);
$destino = "uploads/$carpeta/";

if(!is_dir($destino)){
    mkdir($destino, 0777, true);
}

move_uploaded_file($temp, $destino.$imagen);

$sql = "INSERT INTO productos(nombre,categoria,descripcion,precio,imagen)
VALUES(?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssds", $nombre, $categoria, $descripcion, $precio, $imagen);
$stmt->execute();

header("Location: admin.php");
?>
