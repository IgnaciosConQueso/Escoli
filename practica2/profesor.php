<?php

require_once 'includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal='/includes/vistas/contenidos/profesor.php';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaContenido.php', $params);
?>