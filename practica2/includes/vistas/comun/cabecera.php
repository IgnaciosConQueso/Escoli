<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

function mostrarSaludo()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = "Bienvenido, $nombreUsuario. $htmlLogout";
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        Usuario desconocido. <a href="{$loginUrl}">Login</a> <a href="{$registroUrl}">Registro</a>
      EOS;
    }

    return $html;
}

function resuelveLocal($path = ''){ 
    $url = '';  
    $app = Aplicacion::getInstance(); 
    $url = $app->resuelve($path);
    return $url;
}

?>
<link id="cabecera" type="text/css" rel="stylesheet" href="<?= resuelveLocal('/css/cabecera.css');?>">
<header>
    <a href= "<?= resuelveLocal('index.php'); ?>"> <img class="logo" src="<?= resuelveLocal('/Imagenes/logo.jpg');?>" alt ="logo" title = "Escoli"></a>
    <h1 id="headerTitle">Escoli</h1>
    <div class="saludo">
        <?= mostrarSaludo(); ?>
    </div>
</header>
    
<nav id="top">
    <a href= <?= resuelveLocal('/bocetos.php'); ?>>Bocetos</a>
    <a href="<?= resuelveLocal('/contacto.php'); ?>">Contacto</a>
    <a href="<?= resuelveLocal('/detalles.php'); ?>">Detalles</a>
    <a href="<?= resuelveLocal('/planificacion.php'); ?>">Planificación</a>
    <a href="<?= resuelveLocal('/miembros.php'); ?>">Miembros</a>
</nav>
