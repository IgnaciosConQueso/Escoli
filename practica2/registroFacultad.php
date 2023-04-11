<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\centros\FormularioFacultad();
$formRegistro = $formRegistro->gestiona();


$tituloPagina = 'Registro Facultad';
$contenidoPrincipal = <<<EOF
  	<h1>Registro de Facultad</h1>
    $formRegistro
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>