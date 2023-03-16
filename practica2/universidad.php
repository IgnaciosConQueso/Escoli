<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=<<<EOS
<h1>Universidad</h1>
<p>Esta es la página de la universidad</p>
<a href="facultad.php">Facultad</a>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);