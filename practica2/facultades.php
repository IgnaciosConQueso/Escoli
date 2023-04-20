<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/facultadesHelper.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal = "<h1>Facultades de " . nombreUniversidad($_GET['idUniversidad']) . "</h1>";
$contenidoPrincipal .= listaFacultades($_GET['idUniversidad']);
$menuCabecera = '<a href=' . $app->resuelve('/facultades.php?idUniversidad=' . $_GET['idUniversidad']) . '>Facultad</a>';
$_SESSION['menuCabecera']['anterior'] = $menuCabecera;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'menuCabecera' => $menuCabecera];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);