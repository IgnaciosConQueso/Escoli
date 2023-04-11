<?php

use escoli\Aplicacion;
use escoli\usuarios\FormularioLogout;

function mostrarSaludo()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = $htmlLogout;

        $url = 'perfilAlumno.php?id=' . $app->idUsuario();
        $visitaPerfil = '<a href=' . $url . '><button> Mi perfil </button></a>';
        $html .= $visitaPerfil;
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        <a href="{$loginUrl}">Login</a> <a href="{$registroUrl}">Registro</a>
      EOS;
    }

    return $html;
}

function resuelveLocal($path = '')
{
    $url = '';
    $app = Aplicacion::getInstance();
    $url = $app->resuelve($path);
    return $url;
}

function creaBarraBusqueda()
{
    $html = '';
    $app = Aplicacion::getInstance();
    $url = $app->resuelve('/busqueda.php');
    $html = <<<EOS
    <form action="{$url}" method="get">
      <input type="text" name="busqueda" placeholder="Buscar...">
      <input type="submit" value="Buscar">
    </form>
  EOS;
    return $html;
}

?>
<header>
    <div id="title">
        <a id="linkLogo" href="<?= resuelveLocal('index.php'); ?>"> <img id="logo" src="<?= resuelveLocal('/Imagenes/logo.jpg'); ?>" alt="logo" title="Escoli"></a>
        <h1 id="headerTitle">Escoli</h1>
        <div id="saludo">
            <?= mostrarSaludo(); ?>
        </div>
    </div>

    <nav id="header">
        <div id="menu">
            <a href="<?= resuelveLocal('/contacto.php'); ?>">Contacto</a>
            <a href="<?= resuelveLocal('/detalles.php'); ?>">Detalles</a>
            <?= creaBarraBusqueda(); ?>
        </div>
    </nav>
</header>