<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=<<<EOS
<a href= 'facultad.php'>>Tu universidad</a>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaHDOC.php', $params);