<?php

use escoli\usuarios\Usuario;
use escoli\Aplicacion;
use escoli\Imagen;

function listaUsuariosBusqueda($resBusqueda){
    $html = '';
    if ($resBusqueda) {
        $html .= '<ul class="lista-usuarios">';
        foreach ($resBusqueda as $usuario) {
            $html .= generaHTMLUsuario($usuario);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLUsuario($data){
    $usuario = Usuario::buscaPorId($data->id);
    $imagen = Imagen::buscaPorId($usuario->getIdImagen());
    $htmlImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del usuario">';
    
    $url = 'perfilAlumno.php?id=' . $data->id;
    $html = '<div class="usuario">';
    $html .= '<a class="imagen" href="' . Aplicacion::getInstance()->resuelve($url) . '">' .  $htmlImg . '</a>';
    $html .= '<p class="nombre-usuario"> <a href="' . $url . '">' . $data->nombreUsuario . '</a></p>';
    $html .= '</div>';
    return $html;
}


?>