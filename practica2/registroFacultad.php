<?php

require_once __DIR__ . '/includes/config.php';
$formRegistro = new \escoli\centros\FormularioFacultad();
$formRegistro = $formRegistro->gestiona();

$scriptRegistro = $app->resuelve('js/registroFacultad.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

$tituloPagina = 'Registro Facultad';
$contenidoPrincipal = <<<EOF
  	<h1>Registro de Facultad</h1>
    $formRegistro
    <script type="text/javascript" src=$jQuery></script>
    <script type="text/javascript" src=$scriptRegistro></script>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>