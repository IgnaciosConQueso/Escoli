<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/vistas/helpers/facultad-helper.php';

use function es\ucm\fdi\aw\listaValoraciones;

$tituloPagina = 'Facultad';
$contenidoPrincipal = listaValoraciones();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);