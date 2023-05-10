<?php

require_once __DIR__ . '/includes/config.php';

if(!$app->esAdmin()) {
  $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

$formRegistro = new \escoli\contenido\FormularioAsignatura('valoraciones.php?idFacultad=' . $_GET['idFacultad'] ?? null);

$scriptRegistro = $app->resuelve('js/registroAsignatura.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4

$tituloPagina = 'Registro Asignatura';

if(isset($_POST['id']) && $_POST['id'] !== ""){
  $asignatura = \escoli\contenido\Asignatura::buscaPorId($_POST['id']);
  if($asignatura){//solo si existe la facultad la modificamos
    $_POST['nombre'] = $asignatura->nombre;
    $_POST['facultad'] = $asignatura->idFacultad;
    $tituloPagina = 'Modificación de Asignatura';
  }
  else $_POST['id'] = null;
}
else{
  $_POST['facultad'] = $_GET['idFacultad'] ?? null;
}

if(!$_POST['facultad']){ 
  $app->paginaError(400, 'Error', 'Oops', 'No se ha recibido el id de facultad');
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