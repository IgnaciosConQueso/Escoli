<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracion.php';


//TODO: Comprobar que esto imprime bien las valoraciones del usuario
$contenidoValoraciones = listaValoracionesUsuario($_GET['id']);

$tituloPagina = 'Perfil alumno';
$contenidoPrincipal = <<<EOF
  	<h1>Perfil del alumno</h1>
	$contenidoValoraciones
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>