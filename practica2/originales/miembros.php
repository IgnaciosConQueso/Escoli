
<?php

require_once '../includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=$app->doInclude('/originales/miembrosContenido.php');

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);








