<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/index.php';

$tituloPagina = 'Escoli';
$linkUniversidad = 'registroUniversidad.php';
$linkFacultad = 'registroFacultad.php';
$linkBorraFacultad = 'borraFacultad.php';
$botonUniversidad = '<a href="registroUniversidad.php"> Añadir universidad</a>';
$botonFacultad = '<a href=' . $linkFacultad . '><button> Añadir facultad </button>';
$botonBorraFacultad = '<a href=' . $linkBorraFacultad . '><button> Borrar facultad </button>';
$contenidoPrincipal = listaUniversidades();


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'botonesCabecera' => $botonUniversidad];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>