<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal = "<h1>Valoraciones más recientes</h1>";
$contenidoPrincipal .= listaValoraciones($app->resuelve('/index.php'));

$menuCabecera = '';
$_SESSION['linksCabecera'] = $menuCabecera;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'script' => $app->resuelve('/js/gestionLikes.js')];
$app->generaVista('/plantillas/plantillaPrincipalJS.php', $params);

?>