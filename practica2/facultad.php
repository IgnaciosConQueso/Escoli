<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/facultad.php';

$tituloPagina = 'Facultad';
$contenidoPrincipal = "<h1>Valoraciones de " . nombreFacultad($_GET['id']) . "</h1>";
$contenidoPrincipal .= listaValoraciones($_GET['id']);

$linkValoracion = 'registroValoracion.php?idFacultad=' . $_GET['id'];
$botonValoracion = '<a href=' . $linkValoracion . '> Añadir valoración</a>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'botonesCabecera' => $botonValoracion];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>