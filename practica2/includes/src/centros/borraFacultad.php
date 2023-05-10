<?php

use escoli\centros\Facultad;

require_once '../../config.php';

if(!$app->esAdmin()) {
    $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

$idFacultad = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!isset($idFacultad)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la facultad');
}

$facultad = Facultad::buscaPorId($idFacultad);

if(!Facultad::borra($facultad)){
    $app->paginaError(500, 'Error', 'Oops', 'No se ha podido borrar la facultad');
}

$app->redirige($app->resuelve('/facultades.php?idUniversidad=' . $facultad->idUniversidad));