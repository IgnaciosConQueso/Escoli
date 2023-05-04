<?php

use escoli\centros\Facultad;
use escoli\centros\Universidad;
use escoli\Imagen;
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
    $facultad = Facultad::buscaPorId($data->id);
    if (isset($facultad->imagen)) {
        $imagen = Imagen::buscaPorId($facultad->imagen);
        $htmlImg  = '<img class="imagen" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt="imagen de la facultad">';
    } else {
        $htmlImg = '<img class="imagen" src="' . Aplicacion::getInstance()->resuelveImagen('centros/default.png') . '" alt="imagen de la facultad">';
    }
    $app = Aplicacion::getInstance();
    $url = 'valoraciones.php?idFacultad=' . $data->id;
    $html = '<div class="facultad">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve('valoraciones.php?idFacultad=' . $facultad->getId()) . '">' . '<img src="' . $htmlImg . '</a>';
    $html .= '<p class="nombre-facultad"><a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function nombreUniversidad($idUniversidad)
{
    $universidad = Universidad::buscaPorId($idUniversidad);
    return $universidad->nombre;
}