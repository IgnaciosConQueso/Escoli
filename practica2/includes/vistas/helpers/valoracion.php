<?php

use escoli\contenido\Valoracion;

function listaValoracionesUsuario($id)
{
    $arrayMensajes = Valoracion::buscaValoracionesPorIdUsuario($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion);
            procesaLikes($valoracion);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaTopCinco($id)
{
    $arrayMensajes = Valoracion::buscaTopCincoValoraciones($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-top5-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion);
            procesaLikes($valoracion);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaNumeroDeLikes($id){
    $arrayMensajes = Valoracion::listaNumeroDeLikes($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-num-likes">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLLikesTotales($valoracion);
            procesaLikes($valoracion);
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
    $html .=' <form method="post" action="">
                <input type="submit" name="likes" value="👍">
                <input type="submit" name="dislike" value="👎">
              </form>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

function generaHTMLLikesTotales($valoracion)
{
    $html = '<li>';
    $html .= '<div class="likes">';
    $html .= '<p class="likes">' . "likes: " . $valoracion->likes . '</p>' ;
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

function procesaLikes($valoracion)
{
    if (isset($_POST['likes'])) {
        $valoracion->darLike($valoracion);
        //hay que integrar esto con el id de las reviews para que 
        //no se actualicen todas a la vez.
    } elseif (isset($_POST['dislike'])) {
        $valoracion->dislike($valoracion);
        //existe un error que: si mando un like y luego un dislike son dos likes y viceversa, probar para entender.
    }
}
?>