<?php

use escoli\Aplicacion;
use escoli\centros\Facultad;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/asignaturasHelper.php';
require_once __DIR__ . '/includes/src/Aplicacion.php';

$app = Aplicacion::getInstance();

$idFacultad = $_GET['idFacultad'];
$facultad = Facultad::buscaPorId($idFacultad);
$tituloPagina = $facultad->nombre;

$linkValoracion = 'registroValoracion.php?idFacultad=' . $idFacultad;
$linkAsignatura = 'registroAsignatura.php?idFacultad=' . $idFacultad;
$listaAsignaturas = listaAsignaturasFacultad($idFacultad);
$contenidoValoraciones = listaValoracionesFacultad($idFacultad, $app->resuelve('/facultad.php?id=' . $idFacultad));
$botonValoracion = '<a href=' . $linkValoracion . '> Añadir valoración</a>';
$botonAsignatura = '<a href=' . $linkAsignatura . '> Añadir asignatura</a>';
$_SESSION['menuCabecera']['idFacultad'] = '<a href="valoraciones.php?idFacultad=' . $idFacultad . '">Valoraciones</a>';

$menuCabecera = '';
foreach ($_SESSION['menuCabecera'] as $key => $link) {
  $menuCabecera .= $link;
  if (mb_strpos($key, 'idFacultad') !== false) {
    break;
  }
}
$_SESSION['linksCabecera'] = $menuCabecera;

$botonesCab = '';
if ($app->esAdmin()) {
  $botonesCab = $botonAsignatura;
}
else{
	$botonesCab = $botonValoracion;
}

$contenidoSideBarIzq = <<<EOF
EOF;

$contenidoPrincipal = <<<EOF
<h1>Valoraciones de la $facultad->nombre</h1>
$contenidoValoraciones
EOF;

$contenidoSideBarDer = <<<EOF
<h1>Asignaturas que se imparten</h1>
$listaAsignaturas
EOF;

$script = $app->resuelve('/js/gestionLikes.js');
$params = [
	'tituloPagina' => $tituloPagina,
	'botonesCabecera' => $botonesCab,
	'contenidoSideBarIzq' => $contenidoSideBarIzq,
	'contenidoSideBarDer' => $contenidoSideBarDer,
	'contenidoPrincipal' => $contenidoPrincipal,
	'script' => $script
];
$app->generaVista('/plantillas/plantillaSideBars.php', $params);

?>