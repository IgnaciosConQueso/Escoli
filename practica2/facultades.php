<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/facultadesHelper.php';

$idUniversidad = $_GET['idUniversidad'];

$tituloPagina = 'Escoli';
$contenidoPrincipal = "<h1>Facultades de " . nombreUniversidad($idUniversidad) . "</h1>";
$contenidoPrincipal .= listaFacultades($idUniversidad);
$_SESSION['menuCabecera']['idUniversidad'] = '<a href="facultades.php?idUniversidad=' . $idUniversidad . '">Facultades</a>';

$menuCabecera = '';
foreach ($_SESSION['menuCabecera'] as $key => $link) {
  $menuCabecera .= $link;
  if (mb_strpos($key, 'idUniversidad') !== false) {
    break;
  }
}
$_SESSION['linksCabecera'] = $menuCabecera;

$script = $app->resuelve('/js/gestionLikes.js');

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'script' => $script];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);