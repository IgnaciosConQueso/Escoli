<?php

use escoli\contenido\Valoracion;
use escoli\contenido\Profesor;
use escoli\centros\Facultad;
use escoli\Aplicacion;
use escoli\Formulario;

function listaValoraciones($url, $numPorPag = 10, $pag = 1)
{
    $arrayMensajes = Valoracion::buscaUltimasValoraciones($numPorPag, $pag);
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

function listaValoracionesFacultad($id, $url, $numPorPag = 10, $pag = 1)
{
    $arrayMensajes = Valoracion::buscaUltimasValoracionesFacultad($id, $numPorPag, $pag);
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

function nombreFacultad($idFacultad)
{
    $facultad = Facultad::buscaPorId($idFacultad);
    return $facultad->nombre;
}

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
        $html .= '<div class="lista-top5-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion, $url);

        }
        $html .= '</div>';
    }
    return $html;
}

function generaHTMLValoracion($valoracion, $url)
{
    $html = '<div class="valoracion">';
    $html .= '<p class="nombre-profesor">' . "idProfesor: " . Profesor::nombreProfesorPorId($valoracion->idProfesor) . '</p>';
    $html .= '<p class="puntuacion">' . "puntuacion: " . $valoracion->puntuacion . '</p>';
    $html .= '<p class="fecha">' . "fecha: " . $valoracion->fecha . '</p>';
    $html .= '<p class="comentario">' . "comentario: " . $valoracion->comentario . '</p>';
    $html .= '<p class="likes">' . "likes: " . $valoracion->likes . '</p>';
    $html .= '<button class="boton-like" data-idval = "'. $valoracion->id .
             '" data-likes = "' . $valoracion->likes.  //v Esto no se si se puede hacer de otra forma, abierto a sugerencias.
             '" data-api = "'. Aplicacion::getInstance()->resuelve('/includes/vistas/helpers/api_likes.php').'"
              >👍</button>';
    $html .= '<button class="boton-dislike"data-idval = "'. $valoracion->id .
             '" data-likes = "' . $valoracion->likes. '"
              data-api = "'. Aplicacion::getInstance()->resuelve('/includes/vistas/helpers/api_likes.php').'"
             >👎</button>';
    $html .= '</div>';
    return $html;
}

function muestraLikesTotales($idUser)
{
    $html = '<div class="likes">';
    $html .= '<p class="likes">' . "likes: " . Valoracion::sumaLikes($idUser) . '</p>';
    $html .= '</div>';
    return $html;
}

function botonLike($origen, $id, $likes)
{
    $valor = 1;
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/vistas/helpers/api_likes.php');
    return Formulario::buildButtonForm($api, 
    ['url' => $origen, 'id' => $id, 'likes' => $likes, 'valor' => $valor],
     'like', '👍');
}

function botonDislike($origen, $id, $likes)
{
    $valor = -1;
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/vistas/helpers/api_likes.php');
    return Formulario::buildButtonForm($api, 
    ['url' => $origen, 'id' => $id, 'likes' => $likes, 'valor' => $valor],
     'dislike','👎');
}
?>