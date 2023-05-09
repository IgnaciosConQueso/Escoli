<?php

require_once __DIR__ . '/includes/config.php';

$formRegistro = new \escoli\contenido\FormularioProfesor();

$scriptRegistro = $app->resuelve('js/registroProfesor.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

$tituloPagina = 'Registro Profesor';

if (isset($_GET['id']) && !isset($_POST['id'])) {
  $profesor = \escoli\contenido\Profesor::buscaPorId($_GET['id']);
  if($profesor){//solo si existe la universidad la modificamos
    $_POST['id'] = $profesor->id;
    $_POST['nombre'] = $profesor->nombre;
    $tituloPagina = 'Modificación de Profesor';
  }
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