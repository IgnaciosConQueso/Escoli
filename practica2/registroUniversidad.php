<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\centros\FormularioUniversidad();

$scriptRegistro = $app->resuelve('js/registroUniversidad.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

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
    <script type="text/javascript" src=$jQuery></script>
    <script type="text/javascript" src=$scriptRegistro></script>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>