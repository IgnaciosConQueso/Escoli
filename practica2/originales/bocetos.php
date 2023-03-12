<?php

require_once '../includes/config.php';
use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Escoli';
$contenidoPrincipal=
    Aplicacion:: getInstance()->doInclude('/originales/bocetosContenido.php');

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);