<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\centros\FormularioBorrarUniversidad();
$formRegistro = $formRegistro->gestiona();


$tituloPagina = 'Registro Universdad';
$contenidoPrincipal = <<<EOF
  	<h1>Borrado de Universidad</h1>
    $formRegistro
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>