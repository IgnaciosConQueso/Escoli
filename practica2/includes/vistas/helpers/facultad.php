<?php

use escoli\Valoracion;

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
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}
