<?php

use escoli\contenido\Valoracion;
use escoli\Aplicacion;
use escoli\Formulario;

function listaValoracionesUsuario($id, $url)
{
    $arrayMensajes = Valoracion::buscaValoracionesPorIdUsuario($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion, $url);

        }
        $html .= '</ul>';
    }
    return $html;
}

function listaTopCinco($id, $url)
{
    $arrayMensajes = Valoracion::buscaTopCincoValoraciones($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-top5-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion, $url);

        }
        $html .= '</ul>';
    }
    return $html;
}

function listaNumeroDeLikes($id)
{
    $arrayMensajes = Valoracion::listaNumeroDeLikes($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-num-likes">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLLikesTotales($valoracion);

        }
        $html .= '</ul>';
    }
    return $html;
}
function generaHTMLValoracion($valoracion, $url)
{
    $html = '<li>';
    $html .= '<div class="valoracion">';
    $html .= '<p class="nombre-usuario">' . "idUsuario: " . $valoracion->idUsuario . '</p>';
    $html .= '<p class="nombre-profesor">' . "idProfesor: " . $valoracion->idProfesor . '</p>';
    $html .= '<p class="puntuacion">' . "puntuacion: " . $valoracion->puntuacion . '</p>';
    $html .= '<p class="fecha">' . "fecha: " . $valoracion->fecha . '</p>';
    $html .= '<p class="comentario">' . "comentario: " . $valoracion->comentario . '</p>';
    $html .= '<p class="likes">' . "likes: " . $valoracion->likes . '</p>';
    $html .= botonLike($url, $valoracion->getId(), $valoracion->getLikes());
    $html .= botonDislike($url, $valoracion->getId(), $valoracion->getLikes());
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

function generaHTMLLikesTotales($valoracion)
{
    $html = '<li>';
    $html .= '<div class="likes">';
    $html .= '<p class="likes">' . "likes: " . $valoracion->likes . '</p>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

function botonLike($origen, $id, $likes)
{
    $likes++;
    $idFac = $_GET['id'];
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/src/contenido/api_likes.php');
    return Formulario::buildButtonForm($api, ['url' => $origen, 'id' => $id, 'likes' => $likes], '👍');
}

function botonDislike($origen, $id, $likes)
{
    $likes--;
    $idFac = $_GET['id'];
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/src/contenido/api_likes.php');
    return Formulario::buildButtonForm($api, ['url' => $origen, 'id' => $id, 'likes' => $likes], '👎');
}
?>