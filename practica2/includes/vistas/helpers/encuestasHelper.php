<?php

use escoli\contenido\Encuesta;

function listaEncuestasFacultad($id, $url){
    $arrayEncuestas = Encuesta::buscaPorFacultad($id);
    $html = '';
    if ($arrayEncuestas) {
        $html .= '<ul class="lista-encuestas">';
        foreach ($arrayEncuestas as $encuesta) {
            $html .= generaHTMLEncuesta($encuesta, $url);
        }
        $html .= '</ul>';
    }

    return $html;
}

function generaHTMLEncuesta($encuesta, $url){
    $campos = $encuesta->opciones;
    $i = 1;

    $html = '<li class="encuesta">';
    $html .= '<p class="titulo-encuesta">' . $encuesta->titulo . '</p>';
    foreach ($campos as $campo) {
        $html .= '<div class="campo-encuesta">';
        $html .= '<p class="campo-encuesta" value="'.$i.'">' . $campo['campo'] . '</p>';
        $html .= '<p class="votos-encuesta">' . $campo['votos'] . '</p>';
        $html .= '</div>';
    }
    $html .= '</li>';

    return $html;
}