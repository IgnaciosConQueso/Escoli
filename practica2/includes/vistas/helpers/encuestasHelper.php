<?php

use escoli\Aplicacion;
use escoli\Formulario;
use escoli\contenido\Encuesta;
use escoli\contenido\CampoEncuesta;
use escoli\usuarios\Usuario;
use escoli\Imagen;

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
    $usuario = Usuario::buscaPorId($encuesta->idUsuario);
    $imagen = Imagen::buscaPorId($usuario->idImagen);
    $htmlImg = '<img class="imagen-usuario" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt="Imagen de usuario">';

    $html = '<li class="encuesta">';
    $html .= '<div class="header-encuesta">';
    $html .= '<a class="imagen-usuario" href="' . Aplicacion::getInstance()->resuelve('perfilAlumno.php?id=' . $usuario->id) . '">' . $htmlImg . '</a>';
    $html .= '<div class="info-encuesta">';
    $html .= '<p class="usuario-encuesta">' . $usuario->nombreUsuario;
    $html .= '<p class="titulo-encuesta">' . $encuesta->titulo . '</p>';
    $html .= '</div>';
    $html .= '</div>';
    foreach ($campos as $campo) {
        $html .= '<div class="campo-encuesta">';
        $html .= botonCampoEncuesta($encuesta, $campo, $url);
        $html .= '<p class="votos-encuesta">' . $campo->votos . '</p>';
        $html .= '</div>';
    }
    $html .= '<p class="fecha-encuesta">' . $encuesta->fecha . '</p>';
    $html .= '</li>';

    return $html;
}

function botonCampoEncuesta($encuesta, $campo, $url){
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/vistas/helpers/api_encuestas.php');
    return Formulario::buildButtonForm(
        $api, ['url' => $url, 'idEncuesta' => $encuesta->id, 'idCampo' => $campo->id, 'idFacultad' => $encuesta->idFacultad],
        'boton-votar', $campo->campo);
}