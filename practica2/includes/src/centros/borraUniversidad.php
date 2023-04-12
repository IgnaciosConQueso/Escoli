<?php

use escoli\Aplicacion;
use escoli\centros\Universidad;

require_once '../../config.php';

$app = Aplicacion::getInstance();

$idUniversidad = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!isset($idUniversidad)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la universidad');
}

$universidad = Universidad::buscaPorId($idUniversidad);
//TODO comprobar que el usuario es admin

if(!Universidad::borra($universidad)){
    $app = Aplicacion::getInstance();
    $app->paginaError(500, 'Error', 'Oops', 'No se ha podido borrar la universidad');
}

$app->redirige($app->resuelve('/index.php'));
?>