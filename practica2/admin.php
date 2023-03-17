<?php
require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Admin';
$contenidoPrincipal = '';

if ($app->tieneRol(escoli\Usuarios\Usuario::ADMIN_ROLE)) {
  $contenidoPrincipal = <<<EOS
    <h1>Consola de administración</h1>
    <p>Aquí estarían todos los controles de administración</p>
  EOS;
} else {
  $contenidoPrincipal = <<<EOS
  <h1>Acceso Denegado!</h1>
  <p>No tienes permisos suficientes para administrar la web.</p>
  EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaHDOC.php', $params);

?>