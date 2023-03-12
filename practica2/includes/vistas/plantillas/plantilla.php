<?php
$params['app']->doInclude('includes/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
</head>
<body>
	<?= $mensajes ?>
	<div id="contenedor">

		<?php
		$params['app']->doInclude('includes/vistas/comun/cabecera.php');
		$params['app']->doInclude('includes/vistas/comun/sidebarIzq.php');
		?>
			<main>
				<article>
					<?= $params['contenidoPrincipal'] ?>
				</article>
			</main>
		<?php
		$params['app']->doInclude('includes/vistas/comun/sidebarDer.php');
		$params['app']->doInclude('includes/vistas/comun/pie.php');
		?>
	</div>
</body>
</html>