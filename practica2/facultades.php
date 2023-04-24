<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/facultadesHelper.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal = "<h1>Facultades de " . nombreUniversidad($_GET['idUniversidad']) . "</h1>";
$contenidoPrincipal .= listaFacultades($_GET['idUniversidad']);
$_SESSION['menuCabecera']['idUniversidad'] = '<a href="facultades.php?idUniversidad=' . $_GET['idUniversidad'] . '">Facultades</a>';

$menuCabecera = '';
foreach ($_SESSION['menuCabecera'] as $key => $link) {
  $menuCabecera .= $link;
  if (mb_strpos($key, 'idUniversidad') !== false) {
    break;
  }
}
$_SESSION['linksCabecera'] = $menuCabecera;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);