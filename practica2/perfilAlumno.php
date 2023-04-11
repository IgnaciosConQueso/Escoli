<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracion.php';

$contenidoValoraciones = listaValoracionesUsuario($_GET['id']);
$topCinco = listaTopCinco($_GET['id']);


$tituloPagina = 'Perfil alumno';

$contenidoSideBarIzq = <<<EOF
	<h1>Top 5 Valoraciones</h1>
	$topCinco
EOF;

$contenidoPrincipal = <<<EOF
  	<h1>Perfil del alumno</h1>
	$contenidoValoraciones
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoSideBarIzq' => $contenidoSideBarIzq, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>