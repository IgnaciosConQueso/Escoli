<?php

use escoli\contenido\Valoracion;
use escoli\centros\Facultad;
use escoli\Aplicacion;
use escoli\Formulario;

function listaValoraciones($id = 1, $numPorPag = 10, $pag = 1)
{
    $arrayMensajes = Valoracion::buscaUltimasValoraciones($id, $numPorPag, $pag);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion);  
        }
        $html .= '</ul>';
       
    }
    return $html;
}

function generaHTMLValoracion($valoracion)
{
    $html = '<li>';
    $html .= '<div class="valoracion">';
    $html .= '<p class="nombre-usuario">' . "idUsuario: " . $valoracion->idUsuario . '</p>';
    $html .= '<p class="nombre-profesor">' . "idProfesor: " . $valoracion->idProfesor . '</p>';
    $html .= '<p class="puntuacion">' . "puntuacion: " . $valoracion->puntuacion . '</p>';
    $html .= '<p class="fecha">' . "fecha: " . $valoracion->fecha . '</p>';
    $html .= '<p class="comentario">' . "comentario: " . $valoracion->comentario . '</p>';
    $html .= '<p class="likes">' . "likes: " . $valoracion->likes . '</p>' ;
    $html .= botonLike($valoracion->getId(), $valoracion->getLikes());
    $html .= botonDislike($valoracion->getId(), $valoracion->getLikes());
    $html .= '</div>';
    $html .= '</li>';

    return $html;
}


function botonLike($id,$likes)
{
    $likes++;
    $idFac ='/facultad.php?id=' . $_GET['id'];
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/src/contenido/api_likes.php');
    return Formulario::buildButtonForm($api, ['id' => $id, 'likes' => $likes, 'envia' => $idFac] , '👍');
}

function botonDislike($id,$likes)
{
    $likes--;
    $idFac = '/facultad.php?id=' . $_GET['id'];
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/src/contenido/api_likes.php');
    return Formulario::buildButtonForm($api, ['id' => $id, 'likes' => $likes, 'envia' => $idFac] , '👎');
}

function nombreFacultad($idFacultad)
{
    $facultad = Facultad::buscaPorId($idFacultad);
    return $facultad->nombre;
}

?>