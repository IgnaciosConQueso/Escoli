<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=<<<EOS
<a href= 'profesor.php'>>Tu profesor</a>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);