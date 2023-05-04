<?php

require_once __DIR__ . '/includes/config.php';

$app = \escoli\Aplicacion::getInstance();
$scriptRegistro = $app->resuelve('js/registroValoracion.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

if(!$app->usuarioLogueado()){
    $app->paginaError(403, 'Error', 'Oops', 'Debe estar logueado para acceder a esta página');
}

$_POST['idFacultad'] = $_GET['idFacultad'];

$formVal = new \escoli\contenido\FormularioValoracion();
$formVal = $formVal->gestiona();

$tituloPagina = 'Nueva valoración';

$contenidoPrincipal = <<<EOF
  	<h1>$tituloPagina</h1>
    $formVal
    <script type="text/javascript" src=$jQuery></script>
    <script type="text/javascript" src=$scriptRegistro></script>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>