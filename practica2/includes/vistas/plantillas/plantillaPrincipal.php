<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $params['tituloPagina'] ?>
    </title>
    <link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
    <title>Document</title>
</head>

<body>
    <?= $params['app']->doInclude('/includes/vistas/comun/cabecera.php'); ?>
    <main>
        <?= $params['contenidoPrincipal'] ?>
    </main>
    <?= $params['app']->doInclude('includes/vistas/comun/pie.php'); ?>
</body>

</html>