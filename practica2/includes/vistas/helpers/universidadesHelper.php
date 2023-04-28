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
    $html .= '<a class="imagen"href="' . $url . '">'. '<img src="' . $app->resuelveImagen('logo.png') . '" alt="imagen de la universidad">' . '</a>';
    $html .= '<p class="texto"> <a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= botonBorraUniversidad($data->id);
    $html .= botonEditaUniversidad($data->id);
    $html .= '</div>';
    return $html;
}

function botonBorraUniversidad($idUniversidad)
{
    $app = Aplicacion::getInstance();
    $borraURL = $app->resuelve('/includes/src/centros/borraUniversidad.php');
    $className = 'borra-universidad';
    return Formulario::buildButtonForm($borraURL, $className, ['id' => $idUniversidad] , 'Borrar');
}

function botonEditaUniversidad($idUniversidad)
{
    $app = Aplicacion::getInstance();
    $editaURL = $app->resuelve('/registroUniversidad.php');
    $className = 'edita-universidad';
    return Formulario::buildButtonForm($editaURL, $className, ['id' => $idUniversidad] , 'Editar', [], 'GET');
}
?>