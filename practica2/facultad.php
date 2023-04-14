<?php

use escoli\Aplicacion;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/facultad.php';
require_once __DIR__ . '/includes/src/Aplicacion.php';

$app = Aplicacion::getInstance();

$tituloPagina = 'Facultad';
$contenidoPrincipal = "<h1>Valoraciones de " . nombreFacultad($_GET['id']) . "</h1>";
$contenidoPrincipal .= listaValoraciones($_GET['id'], $app->resuelve('/facultad.php?id=' . $_GET['id']));

$urlScript = $app->resuelve('/includes/src/contenido/likeScript.js');

$params = ['tituloPagina' => $tituloPagina, 'scripts' => $urlScript, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>