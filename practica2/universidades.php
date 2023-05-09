<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/universidadesHelper.php';

$tituloPagina = 'Universidades';

$linkUniversidad = 'registroUniversidad.php';
$linkFacultad = 'registroFacultad.php';
$linkBorraFacultad = 'borraFacultad.php';
$linkProfesor = 'registroProfesor.php';

$botonUniversidad = '<a href='.$linkUniversidad.'>Añadir universidad</a>';
$botonProfesor = '<a href='.$linkProfesor.'>Añadir profesor</a>';
$botonFacultad = '<a href=' . $linkFacultad . '>Añadir facultad</a>';

$menuCabecera = '';
$_SESSION['linksCabecera'] = $menuCabecera;

$botonesCab = $botonUniversidad . $botonFacultad . $botonProfesor;
$contenidoPrincipal = listaUniversidades();


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'botonesCabecera' => $botonesCab];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>