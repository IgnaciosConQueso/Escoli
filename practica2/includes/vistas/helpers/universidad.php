<?php

use escoli\centros\Facultad;

function listaFacultades($idFacultad)
{
//recibe todas las facultades de una universidad
    $arrayFacultades = Facultad::buscaFacultades($idFacultad);
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
    $url = 'facultad.php?id=' . $data->id;
    $html = '<li>';
    $html .= '<div class="facultad">';
    $html .= '<p class="nombre-facultad">';
    $html .= '<a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

?>