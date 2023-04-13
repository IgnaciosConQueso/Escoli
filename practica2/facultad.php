<?php

use escoli\Aplicacion;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/facultad.php';
require_once __DIR__ . '/includes/src/Aplicacion.php';

$tituloPagina = 'Facultad';
$contenidoPrincipal = "<h1>Valoraciones de " . nombreFacultad($_GET['id']) . "</h1>";
$contenidoPrincipal .= listaValoraciones($_GET['id']);

$urlScript = Aplicacion :: getInstance()->resuelve('/includes/src/contenido/likeScript.js');

$params = ['tituloPagina' => $tituloPagina, 'scripts' => $urlScript, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipalJS.php', $params);

?>