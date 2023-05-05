<?php

use escoli\Aplicacion;
use escoli\contenido\Profesor;
use escoli\Imagen;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';

$app = Aplicacion::getInstance();

$idProfesor = $_GET['id'];

$nombreProfesor = Profesor::nombreProfesorPorId($idProfesor);
$imagenProfesor = Imagen::buscaPorId($idProfesor->idImagen);
$contenidoValoraciones = listaValoracionesProfesor($idProfesor, $app->resuelve('/perfilProfesor.php'));

$tituloPagina = 'Perfil profesor';

$contenidoSideBarIzq = <<<EOF
	<h1>Información del profesor</h1>
	<h2>Nombre</h2>
    $nombreProfesor
    $imagenProfesor
EOF;

$contenidoPrincipal = <<<EOF
  	<h1>Valoraciones del Profesor</h1>
	$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
EOF;

$script = $app->resuelve('/js/gestionLikes.js');

$params = ['tituloPagina' => $tituloPagina, 'contenidoSideBarIzq' => $contenidoSideBarIzq, 
			'contenidoSideBarDer' => $contenidoSideBarDer, 'contenidoPrincipal' => $contenidoPrincipal, 'script' => $script ];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>