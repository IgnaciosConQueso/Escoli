<?php


require_once __DIR__ . '/valoracion.php';

use escoli\contenido\Valoracion;
use escoli\centros\Facultad;


function listaValoraciones($id = 1, $url, $numPorPag = 10, $pag = 1)
{
    $arrayMensajes = Valoracion::buscaUltimasValoraciones($id, $numPorPag, $pag);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-valoraciones">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracion($valoracion, $url);  
        }
        $html .= '</ul>';
       
    }
    return $html;
}

function nombreFacultad($idFacultad)
{
    $facultad = Facultad::buscaPorId($idFacultad);
    return $facultad->nombre;
}

?>