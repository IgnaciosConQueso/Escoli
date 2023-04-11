<?php

use escoli\Aplicacion;

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracion.php';


//TODO: Comprobar que esto imprime bien las valoraciones del usuario
$idUser = $app->idUsuario();
$contenidoValoraciones = listaValoracionesUsuario($idUser);

$tituloPagina = 'Perfil alumno';
$contenidoPrincipal = <<<EOF
  	<h1>Perfil del alumno</h1>
	$contenidoValoraciones
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>