<?php

use escoli\contenido\Asignatura;

require_once '../../config.php';

if (!$app->esAdmin()) {
    $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

$idAsignatura = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!isset($idAsignatura)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la asignatura');
}

$asignatura = Asignatura::buscaPorId($idAsignatura);

if (!Asignatura::borra($asignatura)) {
    $app->paginaError(500, 'Error', 'Oops', 'No se ha podido borrar la asignatura');
}

$app->redirige($app->resuelve('/valoraciones.php?idFacultad=' . $asignatura->idFacultad));