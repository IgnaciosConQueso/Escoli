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

$botonCabecera = '<a href=' . $app->resuelve('/valoraciones.php?idFacultad=' . $_GET['idFacultad']) . '>Valoraciones</a>';
if (mb_strpos($_SESSION['menuCabecera']['anterior'], $botonCabecera) === false) {
    $_SESSION['menuCabecera']['anterior'] .= $botonCabecera;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal,
    'botonesCabecera' => $botonValoracion, 'menuCabecera' => $_SESSION['menuCabecera']['anterior']];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>