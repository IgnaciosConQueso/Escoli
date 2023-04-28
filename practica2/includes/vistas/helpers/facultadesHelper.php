<?php

use escoli\centros\Facultad;
use escoli\centros\Universidad;

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

function generaHTMLFacultad($data)
{
    $url = 'valoraciones.php?idFacultad=' . $data->id;
    $html = '<div class="facultad">';
    $html .= '<p class="nombre-facultad">';
    $html .= '<a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function nombreUniversidad($idUniversidad)
{
    $universidad = Universidad::buscaPorId($idUniversidad);
    return $universidad->nombre;
}