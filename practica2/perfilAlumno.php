<?php

use escoli\Aplicacion;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';

$app = Aplicacion::getInstance();

$idUser = $app->idUsuario();
$nombreUser = $app->nombreUsuario();
$contenidoValoraciones = listaValoracionesUsuario($idUser, $app->resuelve('/perfilAlumno.php'));
$numLikes = muestraLikesTotales($idUser);
$topCinco = listaTopCinco($idUser, $app->resuelve('/perfilAlumno.php'));

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
	<div class="seccion-usuario">	
	<h1>Nombre de usuario</h1>
	$nombreUser
	<h1>Numero de likes</h1>
	$numLikes 
	</div>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoSideBarIzq' => $contenidoSideBarIzq, 
			'contenidoSideBarDer' => $contenidoSideBarDer, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>