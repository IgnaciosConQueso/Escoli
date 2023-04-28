<?php

require_once __DIR__ . '/includes/config.php';

$app = \escoli\Aplicacion::getInstance();

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
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>