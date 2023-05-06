<?php

use escoli\contenido\Asignatura;

function listaAsignaturasProfesor($idProfesor)
{
    $arrayAsignaturas = Asignatura::getAsignaturasProfesor($idProfesor);
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

function generaHTMLAsignatura($asignatura)
{
    $url = 'valoraciones.php?idAsignatura=' . $asignatura->getId();
    $html = '<div class="asignatura">';
    $html .= '<p class="nombre-asignatura">' . $asignatura->nombre . '</p>';
    $html .= '</div>';
    return $html;
}

?>