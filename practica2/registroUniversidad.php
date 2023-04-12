<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\centros\FormularioUniversidad();

$tituloPagina = 'Registro Universdad';

if (isset($_GET['id']) && !isset($_POST['id'])) {
  $universidad = \escoli\centros\Universidad::buscaPorId($_GET['id']);
  $_POST['id'] = $universidad->id;
  $_POST['nombre'] = $universidad->nombre;
  $tituloPagina = 'Modificación de Universidad';
}

$formRegistro = $formRegistro->gestiona();

$contenidoPrincipal = <<<EOF
  	<h1>$tituloPagina</h1>
    $formRegistro
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>