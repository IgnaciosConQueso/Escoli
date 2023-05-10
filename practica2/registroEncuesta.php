<?
require_once __DIR__ . '/includes/config.php';

if(!$app->esAdmin() || !$app->esModerador()) {
  $app->paginaError(403, 'Error', 'Oops', 'No tienes permiso para acceder a esta página');
}

?>