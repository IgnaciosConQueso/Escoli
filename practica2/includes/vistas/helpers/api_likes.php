<?php

use escoli\Aplicacion;
use escoli\contenido\Valoracion;
use escoli\contenido\LikesyKarma;

require_once '../../config.php';

$app = Aplicacion::getInstance();

$idValoracion = filter_input(INPUT_POST, 'idValoracion', FILTER_SANITIZE_NUMBER_INT);
$likes = filter_input(INPUT_POST, 'likes', FILTER_SANITIZE_NUMBER_INT);
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_INT);

$succes = true;
$message = "";

if(!isset($idValoracion)) {
    $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de la review');
}

if((!$app->idUsuario())){
    //compruebo que el que da like es un usuario.
    $succes = false;
    $message = "Debes iniciar sesión para dar likes";
    $response = array("success" => $success, "message" => $message);
    echo json_encode($response);
    return;
}
if(LikesyKarma :: existeLike($app->idUsuario(), $idValoracion)){
    $valorBD = LikesyKarma :: valorLike($app->idUsuario(), $idValoracion);
    if($valorBD === 0){
        $succes = false;
        $message = "Algo feo feo esta pasando en missouri. (Error en la BD)";
        $response = array("success" => $success, "message" => $message);
        echo json_encode($response);
        return;
    } else if($valorBD === $valor){
        $succes = false;
        $message = "No puedes dar Like más de una vez chulopan.";
        $response = array("success" => $success, "message" => $message);
        echo json_encode($response);
        return;
    }
}
$likes += $valor;
Valoracion::actualizaLikes($idValoracion, $likes);

$succes = true;
$message = "Diste Like o diste dislike da igual porque no vas a ver esto. ;PP";
$response = array("success" => $success, "message" => $message);
echo json_encode($response);
return;


?>


