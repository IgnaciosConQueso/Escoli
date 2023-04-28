<?php

require_once __DIR__ . '/includes/config.php';

$app = \escoli\Aplicacion::getInstance();
$app->paginaError(403, 'Error', 'Oops', 'Página en construcción');

?>