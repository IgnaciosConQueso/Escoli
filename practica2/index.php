<?php

require_once 'includes/config.php';

$tituloPagina = 'Portada';

$contenidoPrincipal=<<<EOS
<h1>Universidad:</h1>
	<p> Aqui se podran elegir las distintas universidades visible para todos los usuarios.</p>
EOS;

require 'includes/vistas/comun/layout.php';
