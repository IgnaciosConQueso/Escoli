<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\usuarios\FormularioRegistro();
$formRegistro = $formRegistro->gestiona();
$scriptRegistro = $app->resuelve('js/registro.js');

$tituloPagina = 'Registro';
$contenidoPrincipal = <<<EOF
  	<h1>Registro de usuario</h1>
    $formRegistro
    <script src=$scriptRegistro type="text/javascript"></script>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);
?>