<?php

use escoli\centros\Universidad;
use escoli\Formulario;
use escoli\Aplicacion;

function listaUniversidades()
{
    $arrayUniversidades = Universidad::buscaUniversidades();
    $html = '';
    if ($arrayUniversidades) {
        $html .= '<ul class="lista-universidades">';
        foreach ($arrayUniversidades as $universidad) {
            $html .= generaHTMLUniversidad($universidad);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLUniversidad($data)
{
    $app = Aplicacion::getInstance();
    $url = 'facultades.php?idUniversidad=' . $data->id;
    $html = '<div class="universidad">';
    $html .= '<p class="nombre-universidad">';
    $html .= '<a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '<a href="' . $url . '">'. '<img src="' . $app->resuelveImagen('logo.png') . '" alt="imagen de la universidad" class="imagen-universidad">' . '</a>';

    /* $html .= '<a href="' . $url . '">'. '<img src="' . RUTA_IMGS . $data->ruta . '" alt="imagen de la universidad" class="imagen-universidad">' . '</a>';*/$html .= botonBorraUniversidad($data->id);
    $html .= botonEditaUniversidad($data->id);
    $html .= '</div>';
    return $html;
}

function botonBorraUniversidad($idUniversidad)
{
    $app = Aplicacion::getInstance();
    $borraURL = $app->resuelve('/includes/src/centros/borraUniversidad.php');
    return Formulario::buildButtonForm($borraURL, ['id' => $idUniversidad] , 'Borrar');
}

function botonEditaUniversidad($idUniversidad)
{
    $app = Aplicacion::getInstance();
    $editaURL = $app->resuelve('/registroUniversidad.php');
    return Formulario::buildButtonForm($editaURL, ['id' => $idUniversidad] , 'Editar', [], 'GET');
}
?>