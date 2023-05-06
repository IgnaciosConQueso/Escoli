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
    $htmlProfImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del profesor">';

$nombreProfesor = Profesor::nombreProfesorPorId($idProfesor);
$imagenProfesor = Imagen::buscaPorId($idImagenProf);
$img = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del usuario">';
$mediaValoraciones = generaMediaValoraciones($idProfesor);
$contenidoValoraciones = listaValoracionesProfesor($idProfesor);
$asignaturas = listaAsignaturasProfesor($idProfesor);

$tituloPagina = 'Perfil profesor';

$contenidoSideBarIzq = <<<EOF
	<h1>Información del profesor</h1>
	<h2>Nombre</h2>
    $nombreProfesor
	$img
	$mediaValoraciones
EOF;

$contenidoPrincipal = <<<EOF
  	<h1>Valoraciones del Profesor</h1>
	$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
	<h1>Asignatura que imparte</h1>
	$asignaturas
EOF;

$script = $app->resuelve('/js/gestionLikes.js');

$params = ['tituloPagina' => $tituloPagina, 'contenidoSideBarIzq' => $contenidoSideBarIzq, 
			'contenidoSideBarDer' => $contenidoSideBarDer, 'contenidoPrincipal' => $contenidoPrincipal, 'script' => $script ];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>