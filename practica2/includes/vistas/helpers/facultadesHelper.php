<?php

use escoli\centros\Facultad;
use escoli\centros\Universidad;
use escoli\Aplicacion;

function listaFacultades($idFacultad)
{
    //recibe todas las facultades de una universidad
    $arrayFacultades = Facultad::buscaFacultades($idFacultad);
    $html = '';
    if ($arrayFacultades) {
        $html .= '<ul class="lista-facultades">';
        foreach ($arrayFacultades as $data) {
            $html .= generaHTMLFacultad($data);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLFacultad($data)
{
    $app = Aplicacion::getInstance();
    $url = 'valoraciones.php?idFacultad=' . $data->id;
    $html = '<div class="facultad">';
    $html .= '<a class="imagen" href="' . $url . '">' . '<img src="' .  $app->resuelveImagen('logo.png') . '" alt="imagen de la facultad">' . '</a>';
    $html .= '<p class="nombre-facultad"><a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function nombreUniversidad($idUniversidad)
{
    $universidad = Universidad::buscaPorId($idUniversidad);
    return $universidad->nombre;
}