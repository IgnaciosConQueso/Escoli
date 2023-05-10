<?php

use escoli\contenido\Profesor;
use escoli\Imagen;
use escoli\Aplicacion;

function listaProfesores($idAsignatura)
{
    $arrayProfesores = Profesor::buscaProfesoresAsignatura($idAsignatura);
    $html = '';
    if ($arrayProfesores) {
        $html .= '<ul class="lista-profesores">';
        foreach ($arrayProfesores as $profesor) {
            $html .= generaHTMLProfesor($profesor);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaProfesoresBusqueda($resBusqueda){
    $html = '';
    if ($resBusqueda) {
        $html .= '<ul class="lista-profesores">';
        foreach ($resBusqueda as $profesor) {
            $html .= generaHTMLProfesor($profesor);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLProfesor($profesor)
{
    $profesor = Profesor::buscaPorId($profesor->id);
    $imagen = Imagen::buscaPorId($profesor->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del profesor">';
    
    $url = 'perfilProfesor.php?id=' . $profesor->getId();
    $html = '<div class="profesor">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve($url) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-profesor"><a href="' . $url . '">' . $profesor->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}