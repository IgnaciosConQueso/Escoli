<?php

use escoli\Aplicacion;
use escoli\contenido\Asignatura;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/asignaturasHelper.php';

$app = Aplicacion::getInstance();

$tituloPagina = 'Asignatura';

$idAsignatura = $_GET['idAsignatura'];
$nombreAsignatura = Asignatura::buscaPorId($idAsignatura)->nombre;

$contenidoValoraciones = listaValoracionesAsignatura($idAsignatura, $app->resuelve('asignatura.php?idAsignatura=' . $idAsignatura));
$listaProfesores = listaProfesores($idAsignatura);

$contenidoSideBarIzq = <<<EOF
EOF;

$contenidoPrincipal = <<<EOF
<h1>Información de la asignatura $nombreAsignatura</h1>
$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
<h1>Profesores que la imparten</h1>
$listaProfesores
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