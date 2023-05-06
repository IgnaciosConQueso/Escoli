<?php

use escoli\centros\Facultad;
use escoli\centros\Universidad;
use escoli\Imagen;
use escoli\Aplicacion;

function listaFacultades($idFacultad)
{
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
    $imagen = Imagen::buscaPorId($facultad->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de la facultad">';
    
    $url = 'valoraciones.php?idFacultad=' . $data->id;
    $html = '<div class="facultad">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve('valoraciones.php?idFacultad=' . $facultad->getId()) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-facultad"><a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function nombreUniversidad($idUniversidad)
{
    $universidad = Universidad::buscaPorId($idUniversidad);
    return $universidad->nombre;
}