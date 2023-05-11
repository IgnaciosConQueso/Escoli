<?php
require_once __DIR__ . '/includes/config.php';

$app = \escoli\Aplicacion::getInstance();

$accesoPermitido = $app->esAdmin()||$app->esModerador();
if(!($accesoPermitido)) {
  $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
} else {
  $form = new \escoli\contenido\FormularioEncuesta();
  $form = $form->gestiona();
  $tituloPagina = 'Registro Encuesta';

  $html = <<<EOF
    <h1>$tituloPagina</h1>
    $form
  EOF;

  $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $html];
  $app->generaVista('/plantillas/plantillaPrincipal.php', $params);

}
?>