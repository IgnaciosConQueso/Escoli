<?php

use escoli\centros\Facultad;
use escoli\centros\Universidad;
use escoli\Imagen;
use escoli\Aplicacion;
use escoli\Formulario;

function listaFacultades($idFacultad)
{
    $arrayFacultades = Facultad::buscaFacultades($idFacultad);
    $html = '';
    if ($arrayFacultades) {
        $html .= '<ul class="lista-facultades">';
        foreach ($arrayFacultades as $data) {
            $html .= generaHTMLFacultad($data);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaFacultadesAdmin($idFacultad)
{
    $arrayFacultades = Facultad::buscaFacultades($idFacultad);
    $html = '';
    if ($arrayFacultades) {
        $html .= '<ul class="lista-facultades">';
        foreach ($arrayFacultades as $data) {
            $html .= generaHTMLFacultadAdmin($data);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLFacultad($data)
{
    $facultad = Facultad::buscaPorId($data->id);
    $imagen = Imagen::buscaPorId($facultad->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de la facultad">';
    
    $url = 'valoraciones.php?idFacultad=' . $data->id;
    $html = '<div class="facultad">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve($url) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-facultad"><a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function generaHTMLFacultadAdmin($data)
{
    $facultad = Facultad::buscaPorId($data->id);
    $imagen = Imagen::buscaPorId($facultad->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de la facultad">';
    
    $url = 'valoraciones.php?idFacultad=' . $data->id;
    $html = '<div class="facultad">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve($url) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-facultad"><a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= botonBorraFacultad($data->id);
    $html .= botonEditaFacultad($data->id);
    $html .= '</div>';
    return $html;
}

function nombreUniversidad($idUniversidad)
{
    $universidad = Universidad::buscaPorId($idUniversidad);
    return $universidad->nombre;
}

function botonBorraFacultad($idFacultad)
{
    $app = Aplicacion::getInstance();
    $borraUrl = $app->resuelve('/includes/src/centros/borraFacultad.php');
    $className = 'boton-borra-facultad';
    return Formulario::buildButtonForm($borraUrl,  ['id' => $idFacultad], $className, 'Borrar');
}

function botonEditaFacultad($idFacultad)
{
    $app = Aplicacion::getInstance();
    $editaUrl = $app->resuelve('/registroFacultad.php');
    $className = 'boton-edita-facultad';
    return Formulario::buildButtonForm($editaUrl,  ['id' => $idFacultad], $className, 'Editar');
}