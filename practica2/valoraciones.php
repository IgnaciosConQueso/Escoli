<?php

use escoli\Aplicacion;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';
require_once __DIR__ . '/includes/src/Aplicacion.php';

$app = Aplicacion::getInstance();

$tituloPagina = 'Facultad';
$contenidoPrincipal = "<h1>Valoraciones de " . nombreFacultad($_GET['idFacultad']) . "</h1>";
$contenidoPrincipal .= listaValoracionesFacultad($_GET['idFacultad'], $app->resuelve('/facultad.php?id=' . $_GET['idFacultad']));

$linkValoracion = 'registroValoracion.php?idFacultad=' . $_GET['idFacultad'];
$botonValoracion = '<a href=' . $linkValoracion . '> Añadir valoración</a>';
$_SESSION['menuCabecera']['idFacultad'] = '<a href="valoraciones.php?idFacultad=' . $_GET['idFacultad'] . '">Valoraciones</a>';

$menuCabecera = '';
foreach ($_SESSION['menuCabecera'] as $key => $link) {
  $menuCabecera .= $link;
  if (mb_strpos($key, 'idFacultad') !== false) {
    break;
  }
}
$_SESSION['linksCabecera'] = $menuCabecera;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal,
    'botonesCabecera' => $botonValoracion];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>