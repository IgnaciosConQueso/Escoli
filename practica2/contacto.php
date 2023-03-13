<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Escoli';
$contenidoPrincipal='/includes/vistas/contenidos/contacto.php';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaContenido.php', $params);