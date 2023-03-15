<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
</head>

<body>
	<?= $params['app']->doInclude('/includes/vistas/comun/cabecera.php'); ?>
	<div id="mainContent">
		<!--<?= $params['app']->doInclude('includes/vistas/comun/sidebarIzq.php'); ?>-->
		<main>
            <?= $params['contenidoPrincipal'] ?>
		</main>
		<!--<?= $params['app']->doInclude('includes/vistas/comun/sidebarDer.php'); ?>-->
	</div>
	<?= $params['app']->doInclude('includes/vistas/comun/pie.php'); ?>
</body>

</html>