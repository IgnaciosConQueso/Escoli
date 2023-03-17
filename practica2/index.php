<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/index.php';

$tituloPagina = 'Escoli';
$linkUniversidad = 'registroUniversidad.php';
$linkFacultad = 'registroFacultad.php';
$botonUniversad = '<a href=' . $linkUniversidad . '><button> Añadir universidad </button>';
$botonFacultad = '<a href=' . $linkFacultad . '><button> Añadir facultad </button>';
$contenidoPrincipal = listaUniversidades() . $botonUniversad . $botonFacultad;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>