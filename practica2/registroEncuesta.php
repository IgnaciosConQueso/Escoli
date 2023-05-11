<?
require_once __DIR__ . '/includes/config.php';
use escoli\contenido\FormularioEncuesta;
$app = \escoli\Aplicacion::getInstance();

$accesoPermitido = $app->esAdmin() || $app->esModerador();

if(!$accesoPermitido) {
  $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

$form = new FormularioEncuesta();
$form = $form->gestiona();
$html = "";
$tituloPagina = 'Registro Encuesta';

/*
$scriptEncuesta = $app->resuelve('js/registroEncuesta.js');
$jQuery = $app->resuelve('js/jquery-3.6.0.min.js');//cogido del ejercicio 4
*/

$html .= <<<EOF
  <h1>$tituloPagina</h1>
  $form
EOF;

//añadimos los scripts
//<script type="text/javascript" src=$jQuery></script><script type="text/javascript" src=$scriptRegistro></script>

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $html];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);
?>