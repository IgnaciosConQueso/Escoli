<?php

use escoli\contenido\Asignatura;
use escoli\contenido\Profesor;

function listaAsignaturasProfesor($idProfesor)
{
    $arrayAsignaturas = Asignatura::buscaAsignaturasProfesor($idProfesor);
    $html = '';
    if ($arrayAsignaturas) {
        $html .= '<ul class="lista-asignaturas">';
        foreach ($arrayAsignaturas as $asignatura) {
            $html .= generaHTMLAsignatura($asignatura);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaAsignaturasFacultad($idFacultad)
{
    $arrayAsignaturas = Asignatura::buscaAsignaturasPorIdFacultad($idFacultad);
    $html = '';
    if ($arrayAsignaturas) {
        $html .= '<ul class="lista-asignaturas">';
        foreach ($arrayAsignaturas as $asignatura) {
            $html .= generaHTMLAsignatura($asignatura);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaAsignaturasBusqueda($resBusqueda)
{
    $html = '';
    if ($resBusqueda) {
        $html .= '<ul class="lista-asignaturas">';
        foreach ($resBusqueda as $asignatura) {
            $html .= generaHTMLAsignatura($asignatura);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLAsignatura($asignatura)
{
    $url = 'asignatura.php?idAsignatura=' . $asignatura->id;
    $html = '<div class="asignatura">';
    $html .= '<p class="nombre-asignatura"><a href="' . $url . '">' . $asignatura->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}



?>