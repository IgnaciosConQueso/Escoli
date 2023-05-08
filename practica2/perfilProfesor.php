<?php

use escoli\Aplicacion;
use escoli\contenido\Profesor;
use escoli\Imagen;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/asignaturasHelper.php';

$app = Aplicacion::getInstance();

$idProfesor = $_GET['id'];
$profesor = Profesor::buscaPorId($idProfesor);
$imagen = Imagen::buscaPorId($profesor->idImagen);
$htmlProfImg = '<img class="imagen-perfil" src="' . $app->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del profesor">';

$nombreProfesor = $profesor->nombre;
$img = '<img class="imagen-perfil" src="' . $app->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del usuario">';
$mediaValoraciones = generaMediaValoraciones($idProfesor);
$contenidoValoraciones = listaValoracionesProfesor($idProfesor, $app->resuelve('perfilProfesor.php?id=' . $idProfesor)); 
$asignaturas = listaAsignaturasProfesor($idProfesor);

$tituloPagina = 'Perfil profesor';

$contenidoSideBarIzq = <<<EOF
	<h1>Información del profesor</h1>
	<ul class="informacion-perfil">
	<li class="info">
		$img
		<p>$nombreProfesor</p>
		<p>$mediaValoraciones</p>
	</li>
	</ul>
EOF;

$contenidoPrincipal = <<<EOF
  	<h1>Valoraciones de $nombreProfesor</h1>
	$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
	<h1>Asignatura que imparte</h1>
	$asignaturas
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