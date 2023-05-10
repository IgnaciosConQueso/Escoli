<?php

use escoli\contenido\Asignatura;
use escoli\Aplicacion;
use escoli\Formulario;

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

function listaAsignaturasFacultadAdmin($idFacultad)
{
    $arrayAsignaturas = Asignatura::buscaAsignaturasPorIdFacultad($idFacultad);
    $html = '';
    if ($arrayAsignaturas) {
        $html .= '<ul class="lista-asignaturas">';
        foreach ($arrayAsignaturas as $asignatura) {
            $html .= generaHTMLAsignaturaAdmin($asignatura);
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

function generaHTMLAsignaturaAdmin($asignatura)
{
    $url = 'asignatura.php?idAsignatura=' . $asignatura->id;
    $html = '<div class="asignatura">';
    $html .= '<p class="nombre-asignatura"><a href="' . $url . '">' . $asignatura->nombre . '</a></p>';
    $html .= botonEditaAsignatura($asignatura->id);
    $html .= botonBorraAsignatura($asignatura->id);
    $html .= '</div>';
    return $html;
}

function botonEditaAsignatura($idAsignatura)
{
    $app = Aplicacion::getInstance();
    $editaURL = $app->resuelve('/registroAsignatura.php');
    $className = 'edita-asignatura';
    return Formulario::buildButtonForm($editaURL, ['id' => $idAsignatura], $className , 'Editar');
}

function botonBorraAsignatura($idAsignatura)
{
    $app = Aplicacion::getInstance();
    $borraURL = $app->resuelve('/includes/src/contenido/borraAsignatura.php');
    $className = 'borra-asignatura';
    return Formulario::buildButtonForm($borraURL, ['id' => $idAsignatura], $className , 'Borrar');
}

?>