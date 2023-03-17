<?php

use escoli\centros\Universidad;

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

function generaHTMLUniversidad($data) //TODO
{
    $url = 'universidad.php?id=' . $data->id;
    $html = '<li>';
    $html .= '<div class="universidad">';
    $html .= '<p class="nombre-universidad">';
    $html .= '<a href="' . $url . '">' . $data->nombre . '</a></p>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

?>