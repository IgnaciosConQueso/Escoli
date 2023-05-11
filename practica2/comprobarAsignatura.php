<?php
    //comprobacion en la base de datos que la asignatura existe en esa facultad

    require_once __DIR__ . '/includes/config.php';

    use escoli\contenido\Asignatura;

    $response = false;

    $nombre = $_GET['asignatura'];
    $idFacultad = $_GET['idFacultad'];

    $nombre = filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS);
    $idFacultad = filter_var($idFacultad, FILTER_SANITIZE_SPECIAL_CHARS);
    $idFacultad = filter_var($idFacultad, FILTER_SANITIZE_NUMBER_INT);

    $existe = Asignatura::buscaPorNombreYFacultad($nombre, $idFacultad);

    if($existe != false){
        $response = "true";
    }

    echo $response;

    return;
?>