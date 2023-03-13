<?php

require_once 'includes/config.php';

$tituloPagina = 'Detalles';
$contenidoPrincipal='/includes/vistas/contenidos/detalles.php';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaContenido.php', $params);