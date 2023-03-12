<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Detalles';
$contenidoPrincipal=Aplicacion :: getInstance()->doInclude('/originales/detallesContenido.html');


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);