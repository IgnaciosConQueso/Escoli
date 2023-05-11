<?php
require_once __DIR__ . '/includes/config.php';

if(!($app->esAdmin()||$app->esModerador())) {
  $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

$scriptRegistro = $app->resuelve('js/registroValoracion.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');

$_POST['idFacultad'] = $_GET['idFacultad'];

$formEnc = new \escoli\contenido\FormularioEncuesta('valoraciones.php?idFacultad=' . $_GET['idFacultad']);
$formEnc = $formEnc->gestiona();

$tituloPagina = 'Registro Encuesta';

$contenidoPrincipal = <<<EOF
  <h1>$tituloPagina</h1>
  $formEnc
  <script type="text/javascript" src=$jQuery></script>
  <script type="text/javascript" src=$scriptRegistro></script>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>