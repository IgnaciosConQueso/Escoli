<?php

use escoli\Aplicacion;
use escoli\Formulario;
use escoli\contenido\Encuesta;
use escoli\contenido\CampoEncuesta;

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
    $campos = CampoEncuesta::buscaPorEncuesta($encuesta->id);

    $html = '<li class="encuesta">';
    $html .= '<p class="titulo-encuesta">' . $encuesta->titulo . '</p>';
    foreach ($campos as $campo) {
        $html .= '<div class="campo-encuesta">';
        $html .= botonCampoEncuesta($encuesta, $campo, $url);
        $html .= '<p class="votos-encuesta">' . $campo->votos . '</p>';
        
        $html .= '</div>';
    }
    $html .= '</li>';

    return $html;
}

function botonCampoEncuesta($encuesta, $campo, $url){
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/vistas/helpers/api_encuestas.php');
    return Formulario::buildButtonForm(
        $api, ['url' => $url, 'idEncuesta' => $encuesta->id, 'idCampo' => $campo->id],
        'boton-votar', $campo->campo);
}