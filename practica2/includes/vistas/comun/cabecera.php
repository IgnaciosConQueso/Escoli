<?php

require_once __DIR__ . '/../helpers/usuarios.php';

?>
<header>
	<a href="index.php"><img src="/img/logo.jpg" alt="logo" class="logo" title="Escoli"></a>
	<h1>Escoli</h1>
	<nav>
		<a href="universidad.php">Universidad</a>
		<a href="perfil.php">Perfil</a>
	</nav>
	<div class="saludo">
		<?= saludo() ?>
	</div>
</header>