<?php

use escoli\Aplicacion;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracion.php';


$idUser = $app->idUsuario();
$nombreUser = $app->nombreUsuario();
$contenidoValoraciones = listaValoracionesUsuario($idUser, __DIR__);
$numLikes = listaNumeroDeLikes($idUser);
$topCinco = listaTopCinco($idUser, __DIR__);

$tituloPagina = 'Perfil alumno';

$contenidoSideBarIzq = <<<EOF
	<h1>Top 5 Valoraciones</h1>
	$topCinco
EOF;

$contenidoPrincipal = <<<EOF
  	<h1>Perfil del alumno</h1>
	$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
	<h1>Nombre de usuario</h1>
	$nombreUser
	<h1>Numero de likes</h1>
	$numLikes
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoSideBarIzq' => $contenidoSideBarIzq, 
			'contenidoSideBarDer' => $contenidoSideBarDer, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>