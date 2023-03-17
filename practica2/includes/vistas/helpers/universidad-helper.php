<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Facultades;

function listaFacultades()
{
//recibe todas las facultades de una universidad
    $arrayFacultades = Facultades::buscaFacultades();
    $html = '';
    if ($arrayFacultades) {
        $html .= '<ul class="lista-facultades">';
        foreach ($arrayFacultades as $facultad) {
            $html .= generaHTMLFacultad($facultad);
        }
        $html .= '</ul>';
    }
    return $html;

}

function generaHTMLFacultad($data)//TODO
{
    $html = '<li>';
    $html .= '<div class="">';
    $html .= '<p class="nombre-facultad">' . $data->nombre . '</p>';
    $html .= '<p class="descripcion-facultad">' . $data->descripcion . '</p>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}