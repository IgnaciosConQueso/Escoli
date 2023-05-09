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

function listaProfesores($idAsignatura)
{
    $arrayProfesores = Profesor::getProfesoresAsignatura($idAsignatura);
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

function generaHTMLAsignatura($asignatura)
{
    $url = 'asignatura.php?idAsignatura=' . $asignatura->getId();
    $html = '<div class="asignatura">';
    $html .= '<p class="nombre-asignatura"><a href="' . $url . '">' . $asignatura->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function generaHTMLProfesor($profesor)
{
    $url = 'perfilProfesor.php?id=' . $profesor->getId();
    $html = '<div class="profesor">';
    $html .= '<p class="nombre-profesor"><a href="' . $url . '">' . $profesor->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}


?>