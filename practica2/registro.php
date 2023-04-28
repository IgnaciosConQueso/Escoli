<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\usuarios\FormularioRegistro();
$formRegistro = $formRegistro->gestiona();
$scriptRegistro = $app->resuelve('js/registro.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

$tituloPagina = 'Registro usuario';
$contenidoPrincipal = <<<EOF
  	<h1>Registro de usuario</h1>
    $formRegistro
    <script type="text/javascript" src=$jQuery></script>
    <script type="text/javascript" src=$scriptRegistro></script>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);
?>