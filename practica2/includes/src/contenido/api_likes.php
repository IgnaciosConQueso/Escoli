<?php

use escoli\Aplicacion;
use escoli\contenido\Valoracion;

require_once '../../config.php';

$app = Aplicacion::getInstance();

$idValoracion = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$likes = filter_input(INPUT_POST, 'likes', FILTER_SANITIZE_NUMBER_INT);
//$origen = filter_input(INPUT_POST, 'envia', FILTER_SANITIZE_NUMBER_INT);

if(!isset($idValoracion)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la review');
}

$origen = $_POST['envia'];

if(!$app->idUsuario()) //compruebo que el que da like es un usuario. 
    $app->redirige($app->resuelve($origen));

Valoracion::gestionaLikes($idValoracion, $likes);


$app->redirige($app->resuelve($origen));


?>


