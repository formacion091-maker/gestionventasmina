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
?>
