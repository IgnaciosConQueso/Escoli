<?php
    //comprobacion en la base de datos que la facultad existe

    require_once __DIR__ . '/includes/config.php';

    use escoli\centros\Facultad;

    $idUniversidad = $_GET['universidad'];
    $idUniversidad = filter_var($idUniversidad, FILTER_SANITIZE_SPECIAL_CHARS);
    $idUniversidad = filter_var($idUniversidad, FILTER_SANITIZE_NUMBER_INT);

    $nombreFacultad = $_GET['facultad'];
    $nombreFacultad = filter_var($nombreFacultad, FILTER_SANITIZE_SPECIAL_CHARS);

    $response = "false";

    $existe = Facultad::buscaPorNombreYUniversidad($nombreFacultad, $idUniversidad);

    if($existe != false){
        $response = "true";
    }

    echo $response;

    return;
?>