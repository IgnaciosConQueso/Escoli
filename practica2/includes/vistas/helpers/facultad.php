<?php

use escoli\contenido\Valoracion;
use escoli\centros\Facultad;

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
    $html .=' <button onclick="enviarSolicitudAJAX('. $valoracion->id.',' . $valoracion->likes+1 . ')">
                👍</button>
              <button onclick="enviarSolicitudAJAX('. $valoracion->id.',' . $valoracion->likes-1 . ')">
                👎</button>
            
            ';
    $html .= '</div>';
    $html .= '</li>';

    return $html;
}

function procesaLikes($valoracion)
{
    if (isset($_POST['likes'])) {
        $likes = $valoracion->getLikes();
        $likes++;
        $valoracion->gestionaLikes($valoracion->getId(), $likes);
        //hay que integrar esto con el id de las reviews para que 
        //no se actualicen todas a la vez.
    } elseif (isset($_POST['dislike'])) {
        $likes = $valoracion->getLikes();
        $likes--;
        $valoracion->gestionaLikes($valoracion->getId(), $likes);
        //existe un error que: si mando un like y luego un dislike son dos likes y viceversa, probar para entender.
    }
}


function nombreFacultad($idFacultad)
{
    $facultad = Facultad::buscaPorId($idFacultad);
    return $facultad->nombre;
}


?>