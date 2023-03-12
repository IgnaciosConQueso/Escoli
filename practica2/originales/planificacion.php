<?php

require_once '../includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=$app->doInclude('/originales/planificacionContenido.php');


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);