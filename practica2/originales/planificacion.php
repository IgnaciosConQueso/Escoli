<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=Aplicacion :: getInstance()->doInclude('/originales/planificacionContenido.php');


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);