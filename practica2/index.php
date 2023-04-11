<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/index.php';

$tituloPagina = 'Escoli';
$linkUniversidad = 'registroUniversidad.php';
$linkFacultad = 'registroFacultad.php';
$linkBorraUniversidad = 'borraUniversidad.php';
$linkBorraFacultad = 'borraFacultad.php';
$botonUniversidad = '<a href=' . $linkUniversidad . '><button> Añadir universidad </button>';
$botonBorraUniversidad = '<a href=' . $linkBorraUniversidad . '><button> Borrar universidad </button>';
$botonFacultad = '<a href=' . $linkFacultad . '><button> Añadir facultad </button>';
$botonBorraFacultad = '<a href=' . $linkBorraFacultad . '><button> Borrar facultad </button>';
$contenidoPrincipal = listaUniversidades() . $botonUniversidad . $botonBorraUniversidad . $botonFacultad . $botonBorraFacultad;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>