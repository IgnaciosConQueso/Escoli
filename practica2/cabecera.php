<header>
	<a href="index.php"><img src="img/logo.jpg" alt="logo" class="logo" title="Escoli"></a>
	<h1>Escoli</h1>
	<nav>
		<a href="index.php">Universidad</a>
	</nav>

	<div class="saludo">
		<?php
		if (isset($_SESSION['login'])) {
			if (isset($_SESSION["esAdmin"])) {
				echo "Bienvenido {$_SESSION['nombre']}. <a href='logout.php'>(logout)</a>";
			} else {
				echo "Bienvenido {$_SESSION['nombre']}. <a href='logout.php'>(logout)</a>";
			}
		} else {
			echo "Usuario desconocido. <a href='login.php'>Login</a>";
		}
		?>
	</div>
</header>