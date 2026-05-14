<?php
function normalizar_categoria($categoria){
    $categoria = trim((string)$categoria);
    $clave = strtolower($categoria);

    $mapa = [
        'hombres' => 'Hombres',
        'caballeros' => 'Hombres',
        'hombre' => 'Hombres',
        'mujeres' => 'Mujeres',
        'damas' => 'Mujeres',
        'mujer' => 'Mujeres',
        'ninos' => 'Ninos',
        'nino' => 'Ninos'
    ];

    if(isset($mapa[$clave])){
        return $mapa[$clave];
    }

    if(strpos($clave, 'ni') === 0){
        return 'Ninos';
    }

    return 'Hombres';
}

function nombre_categoria($categoria){
    $categoria = normalizar_categoria($categoria);

    if($categoria === 'Ninos'){
        return 'Ni&ntilde;os';
    }

    return htmlspecialchars($categoria);
}

function carpeta_categoria($categoria){
    $categoria = normalizar_categoria($categoria);

    if($categoria === 'Mujeres'){
        return 'mujeres';
    }

    if($categoria === 'Ninos'){
        return 'ninos';
    }

    return 'hombres';
}

function ruta_imagen_producto($imagen, $categoria){
    $imagen = basename((string)$imagen);
    $carpeta = carpeta_categoria($categoria);
    $ruta_categoria = "uploads/$carpeta/$imagen";

    if($imagen !== '' && file_exists($ruta_categoria)){
        return $ruta_categoria;
    }

    foreach(['hombres', 'mujeres', 'ninos'] as $posible_carpeta){
        $ruta = "uploads/$posible_carpeta/$imagen";

        if($imagen !== '' && file_exists($ruta)){
            return $ruta;
        }
    }

    return "uploads/$imagen";
}

function listar_imagenes_categoria($categoria){
    $carpeta = carpeta_categoria($categoria);
    $base = __DIR__."/imagenes/$carpeta";
    $imagenes = [];
    $extensiones = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];

    if(!is_dir($base)){
        return $imagenes;
    }

    $archivos = new DirectoryIterator($base);

    foreach($archivos as $archivo){
        if(!$archivo->isFile()){
            continue;
        }

        $extension = strtolower($archivo->getExtension());

        if(!in_array($extension, $extensiones)){
            continue;
        }

        $ruta = str_replace('\\', '/', $archivo->getPathname());
        $relativa = str_replace(str_replace('\\', '/', __DIR__)."/", '', $ruta);
        $nombre = pathinfo($archivo->getFilename(), PATHINFO_FILENAME);
        $nombre = str_replace(['-', '_'], ' ', $nombre);

        $imagenes[] = [
            'nombre' => ucwords($nombre),
            'ruta' => $relativa,
            'categoria' => normalizar_categoria($categoria)
        ];
    }

    return $imagenes;
}

function enlace_whatsapp_imagen($imagen){
    $telefono = '573232825032';
    $categoria = html_entity_decode(strip_tags(nombre_categoria($imagen['categoria'])), ENT_QUOTES, 'UTF-8');
    $mensaje = "Hola, me interesa esta prenda de la tienda:\n";
    $mensaje .= "Producto: ".$imagen['nombre']."\n";
    $mensaje .= "Categoria: ".$categoria."\n";
    $mensaje .= "Imagen: ".$imagen['ruta'];

    return "https://wa.me/$telefono?text=".rawurlencode($mensaje);
}
?>
