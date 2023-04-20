<?php
use escoli\Aplicacion;
$app = Aplicacion::getInstance();
?>
<footer>
	<div id="links">
		<a href="<?= $app->resuelve('/contacto.php'); ?>">Contacto</a>
		<a href="<?= $app->resuelve('/miembros.php'); ?>">Miembros</a>
		<a href="<?= $app->resuelve('/detalles.php'); ?>">Detalles</a>
	</div>
	<div id="copy">
		<p>© 2023 Escoli. All rights reserved.</p>
		<a class="icons" href="https://github.com/IgnaciosConQueso/Escoli"> <img class="icons" src="<?= $app->resuelve('/Imagenes/github.png'); ?>" alt="github" title="Escoli"></a>
	</div>
</footer>
