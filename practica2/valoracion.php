<?php

require_once __DIR__ . '/includes/config.php';

$formVal = new \escoli\usuarios\FormularioValoracion();
$formVal = $formVal->gestiona();


$tituloPagina = 'Valoración';
$contenidoPrincipal = <<<EOF
  	<h1>NUEVA VALORACIÓN</h1>
    $formVal
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>