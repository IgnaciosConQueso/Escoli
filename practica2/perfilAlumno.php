<?php

use escoli\Aplicacion;
use escoli\Imagen;
use escoli\usuarios\Usuario;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';

$app = Aplicacion::getInstance();

$idUser = $_GET['id'];
$user = Usuario::buscaPorId($idUser);
$imagen = Imagen::buscaPorId($user->idImagen);

$nombreUser = $user->nombreUsuario;
$img = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del usuario">';
$contenidoValoraciones = listaValoracionesUsuario($idUser, $app->resuelve('/perfilAlumno.php'));
$numLikes = muestraLikesTotales($idUser);
$topCinco = listaTopCinco($idUser, $app->resuelve('/perfilAlumno.php'));

$tituloPagina = 'Perfil alumno';

$contenidoSideBarIzq = <<<EOF
	<h1>Información del usuario</h1>
	<ul class="informacion-perfil">
	<li class="info">
		$img
		<p>$nombreUser</p>
		$numLikes
	</li>
	</ul>
EOF;

$contenidoPrincipal = <<<EOF
  	<h1>Perfil del alumno</h1>
	$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
	<h1>Top 5 Valoraciones</h1>
	$topCinco
EOF;

$script = $app->resuelve('/js/gestionLikes.js');

$params = [
	'tituloPagina' => $tituloPagina,
	'contenidoSideBarIzq' => $contenidoSideBarIzq,
	'contenidoSideBarDer' => $contenidoSideBarDer,
	'contenidoPrincipal' => $contenidoPrincipal,
	'script' => $script
];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>