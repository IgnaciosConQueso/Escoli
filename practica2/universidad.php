<?php

require_once __DIR__.'/includes/config.php';
use function es\ucm\fdi\aw\listaFacultades;

$tituloPagina = 'Escoli';
$contenidoPrincipal=listaFacultades();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);