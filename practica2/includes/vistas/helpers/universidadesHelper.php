<?php

use escoli\centros\Universidad;
use escoli\Formulario;
use escoli\Aplicacion;
use escoli\Imagen;

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

function listaUniversidadesAdmin()
{
    $arrayUniversidades = Universidad::buscaUniversidades();
    $html = '';
    if ($arrayUniversidades) {
        $html .= '<ul class="lista-universidades">';
        foreach ($arrayUniversidades as $universidad) {
            $html .= generaHTMLUniversidadAdmin($universidad);
        }
        $html .= '</ul>';
    }
    return $html;
}

function listaUniversidadesBusqueda($resBusqueda)
{
    $html = '';
    if ($resBusqueda) {
        $html .= '<ul class="lista-universidades">';
        foreach ($resBusqueda as $data) {
            $html .= generaHTMLUniversidad($data);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLUniversidad($data){
    $universidad = Universidad::buscaPorId($data->id);
    $imagen = Imagen::buscaPorId($universidad->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de la facultad">';
    
    $url = 'facultades.php?idUniversidad=' . $data->id;
    $html = '<div class="universidad">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve($url) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-universidad"> <a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    return $html;
}

function generaHTMLUniversidadAdmin($data)
{
    $universidad = Universidad::buscaPorId($data->id);
    $imagen = Imagen::buscaPorId($universidad->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de la facultad">';
    
    $url = 'facultades.php?idUniversidad=' . $data->id;
    $html = '<div class="universidad">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve($url) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-universidad"> <a href="' . $url . '">' . $data->nombre . '</a></p>';
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
    return Formulario::buildButtonForm($borraURL, ['id' => $idUniversidad], $className , 'Borrar');
}

function botonEditaUniversidad($idUniversidad)
{
    $app = Aplicacion::getInstance();
    $editaURL = $app->resuelve('/registroUniversidad.php');
    $className = 'edita-universidad';
    return Formulario::buildButtonForm($editaURL, ['id' => $idUniversidad], $className , 'Editar');
}
?>