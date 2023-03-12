<?php

require_once '../includes/config.php';

$tituloPagina = 'Detalles';
$contenidoPrincipal= $app->doInclude('/originales/detallesContenido.html');


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);