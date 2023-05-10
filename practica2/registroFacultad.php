<?php

require_once __DIR__ . '/includes/config.php';

if(!$app->esAdmin()) {
  $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

$formRegistro = new \escoli\centros\FormularioFacultad('universidades.php');

$scriptRegistro = $app->resuelve('js/registroFacultad.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

$tituloPagina = 'Registro Facultad';

if(isset($_POST['id'])){
  $facultad = \escoli\centros\Facultad::buscaPorId($_POST['id']);
  if($facultad){//solo si existe la facultad la modificamos
    $_POST['nombre'] = $facultad->nombre;
    $_POST['universidad'] = $facultad->idUniversidad;
    $tituloPagina = 'Modificación de Facultad';
  }
  else $_POST['id'] = null;
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