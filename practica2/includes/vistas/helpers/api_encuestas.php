<?php

use escoli\contenido\Encuesta;
use escoli\contenido\CampoEncuesta;
require_once '../../config.php';

if(!$app->usuarioLogueado()){
    $app->paginaError(403, 'Error', 'Oops', 'Debe estar logueado para acceder a esta página');
}

$idEncuesta = filter_input(INPUT_POST, 'idEncuesta', FILTER_SANITIZE_NUMBER_INT);
$idCampo = filter_input(INPUT_POST, 'idCampo', FILTER_SANITIZE_NUMBER_INT);
$idUsuario = $app->idUsuario();

if (!isset($idEncuesta)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la encuesta');
}
if (!isset($idCampo)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id del campo');
}

if (! CampoEncuesta::vota($idUsuario, $idEncuesta, $idCampo)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha podido votar');
}

?>