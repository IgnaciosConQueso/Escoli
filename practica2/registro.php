<?php

require_once __DIR__.'/includes/config.php';

$formRegistro = new \escoli\Usuarios\FormularioRegistro();
$formRegistro = $formRegistro->gestiona();


$tituloPagina = 'Registro';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de usuario</h1>
    $formRegistro
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);