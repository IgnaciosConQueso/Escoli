<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/universidad.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal = "<h1>Facultades de " . nombreUniversidad($_GET['id']) . "</h1>";
$contenidoPrincipal .= listaFacultades($_GET['id']);

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);