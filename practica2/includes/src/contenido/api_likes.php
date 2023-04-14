<?php

use escoli\Aplicacion;
use escoli\contenido\Valoracion;
use escoli\contenido\LikesyKarma;

require_once '../../config.php';

$app = Aplicacion::getInstance();

$idValoracion = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$likes = filter_input(INPUT_POST, 'likes', FILTER_SANITIZE_NUMBER_INT);
$origen = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_INT);


if(!isset($idValoracion)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la review');
}

if((!$app->idUsuario()) || (LikesyKarma ::checkLike($app->idUsuario(), $idValoracion) == $valor)
    || ! LikesyKarma :: crea($app->idUsuario(), $idValoracion,$valor)){
    //compruebo que el que da like es un usuario. y que no le va a dar el mismo like.
    $app->redirige($app->resuelve($origen));
}

$likes += $valor;
Valoracion::gestionaLikes($idValoracion, $likes);

$app->redirige($app->resuelve($origen));


?>


