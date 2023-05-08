<?php

use escoli\contenido\Valoracion;
use escoli\contenido\Profesor;
use escoli\centros\Facultad;
use escoli\Aplicacion;
use escoli\contenido\Asignatura;
use escoli\Formulario;
use escoli\Imagen;
use escoli\usuarios\Usuario;

define('NUM_POR_PAG', 10);

function listaUltimasValoraciones($url)
{
    $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $arrayMensajes = Valoracion::buscaUltimasValoraciones(NUM_POR_PAG, $pag);
    $html = listaValoraciones($arrayMensajes, $url);
    $masPaginas = Valoracion::buscaUltimasValoraciones(NUM_POR_PAG, $pag + 1);
    $html .= botonesPaginacion($url, $pag, $masPaginas); 

    return $html;
}

function listaValoracionesProfesor($id, $url)
{
    $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $arrayMensajes = Valoracion::ultimasValoracionesProfesor($id, NUM_POR_PAG, $pag);
    $html = listaValoraciones($arrayMensajes, $url);
    $masPaginas = Valoracion::ultimasValoracionesProfesor($id, NUM_POR_PAG, $pag + 1);
    $html .= botonesPaginacion($url, $pag, $masPaginas);

    return $html;
}

function listaValoracionesFacultad($id, $url)
{
    $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $arrayMensajes = Valoracion::buscaUltimasValoracionesFacultad($id, NUM_POR_PAG, $pag);
    $html = listaValoraciones($arrayMensajes, $url);
    $masPaginas = Valoracion::buscaUltimasValoracionesFacultad($id, NUM_POR_PAG, $pag + 1);
    $html .= botonesPaginacion($url, $pag, $masPaginas);

    return $html;
}

function listaValoracionesAsignatura($id, $url)
{
    $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $arrayMensajes = Valoracion::ultimasValoracionesAsignatura($id, NUM_POR_PAG, $pag);
    $html = listaValoraciones($arrayMensajes, $url);
    $masPaginas = Valoracion::ultimasValoracionesAsignatura($id, NUM_POR_PAG, $pag + 1);
    $html .= botonesPaginacion($url, $pag, $masPaginas);

    return $html;
}

function listaValoracionesUsuario($id, $url)
{
    $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $arrayMensajes = Valoracion::buscaUltimasValoracionesUsuario($id, NUM_POR_PAG, $pag);
    $html = listaValoraciones($arrayMensajes, $url);
    $masPaginas = Valoracion::buscaUltimasValoracionesUsuario($id, NUM_POR_PAG, $pag + 1);
    $html .= botonesPaginacion($url, $pag, $masPaginas);

    return $html;
}

function listaTopCinco($id, $url)
{
    $arrayMensajes = Valoracion::buscaTopCincoValoraciones($id);
    $html = '';
    if ($arrayMensajes) {
        $html .= '<ul class="lista-valoraciones-reducidas">';
        foreach ($arrayMensajes as $valoracion) {
            $html .= generaHTMLValoracionReducida($valoracion);

        }
        $html .= '</ul>';
    }
    return $html;
}

function listaValoraciones($valoraciones, $url)
{
    $html = '';
    if ($valoraciones) {
        $html .= '<ul class="lista-valoraciones">';
        foreach ($valoraciones as $valoracion) {
            $html .= generaHTMLValoracion($valoracion, $url);
        }
        $html .= '</ul>';
    }
    return $html;
}

function generaHTMLValoracion($valoracion, $url)
{
    $usuario = Usuario::buscaPorId($valoracion->idUsuario);
    $imagen = Imagen::buscaPorId($usuario->idImagen);
    $htmlUserImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del usuario">';

    $profesor = Profesor::buscaPorId($valoracion->idProfesor);
    $imagen = Imagen::buscaPorId($profesor->idImagen);
    $htmlProfImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del profesor">';

    $html = '<li class="valoracion">';
    $html .= '<div class="info-perfil">';
    $html .= '<a class="imagen-perfil" href="' . Aplicacion::getInstance()->resuelve('perfilProfesor.php?id=' . $valoracion->idProfesor) . '">' . $htmlProfImg . '</a>';
    $html .= '<div class="info-valoracion">';
    $html .= '<p class="nombre-profesor">' . $profesor->nombre . '</p>';
    $html .= '<p class="puntuacion">' . generaPuntuacion($valoracion->puntuacion) . '</p>';
    $html .= '</div>';
    $html .= '<p class="asignatura">' . Asignatura::buscaPorId($valoracion->idAsignatura)->nombre . '</p>';
    $html .= '</div>';
    $html .= '<p class="comentario">' . $valoracion->comentario . '</p>';
    $html .= '<div class="info-perfil">';
    $html .= '<a class="imagen-perfil" href="' . Aplicacion::getInstance()->resuelve('perfilAlumno.php?id=' . $valoracion->idUsuario) . '">' . $htmlUserImg . '</a>';
    $html .= '<p class="nombre-usuario">' . $usuario->nombreUsuario . '</p>';
    $html .= '</div>';
    $html .= '<div class="footer-valoracion">';
    $html .= '<p class="likes">' . $valoracion->likes . '</p>';
    $html .= '<button class="boton-like" data-idval = "' . $valoracion->id .
        '" data-likes = "' . $valoracion->likes . //v Esto no se si se puede hacer de otra forma, abierto a sugerencias.
        '" data-api = "' . Aplicacion::getInstance()->resuelve('/includes/vistas/helpers/api_likes.php') . '">👍</button>';

    $html .= '<button class="boton-dislike"data-idval = "' . $valoracion->id .
        '" data-likes = "' . $valoracion->likes .
        '" data-api = "' . Aplicacion::getInstance()->resuelve('/includes/vistas/helpers/api_likes.php') . '">👎</button>';

    $html .= '<p class="fecha">' . $valoracion->fecha . '</p>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

function generaHTMLValoracionReducida($valoracion)
{
    $profesor = Profesor::buscaPorId($valoracion->idProfesor);
    $imagen = Imagen::buscaPorId($profesor->idImagen);
    $htmlProfImg = '<img class="imagen-perfil" src="' . Aplicacion::getInstance()->resuelveImagen($imagen->ruta) . '" alt = "foto de perfil del profesor">';

    $html = '<li class="valoracion-reducida">';
    $html .= '<div class="info-perfil">';
    $html .= '<a class="imagen-perfil" href="' . Aplicacion::getInstance()->resuelve('perfilProfesor.php?id=' . $valoracion->idProfesor) . '">' . $htmlProfImg . '</a>';
    $html .= '<div class="info-valoracion">';
    $html .= '<p class="nombre-profesor">' . $profesor->nombre . '</p>';
    $html .= '<p class="puntuacion">' . generaPuntuacion($valoracion->puntuacion) . '</p>';
    $html .= '</div>';
    $html .= '<p class="asignatura">' . Asignatura::buscaPorId($valoracion->idAsignatura)->nombre . '</p>';
    $html .= '</div>';
    $html .= '<p class="comentario">' . "comentario: " . $valoracion->comentario . '</p>';
    $html .= '<div class="footer-valoracion-reducida">';    
    $html .= '<p class="likes">' . "likes: " . $valoracion->likes . '</p>';
    $html .= '<p class="fecha">' . "fecha: " . $valoracion->fecha . '</p>';
    $html .= '</div>';
    $html .= '</li>';
    return $html;
}

function muestraLikesTotales($idUser)
{
    $html = '<div class="likes">';
    $html .= '<p class="likes">' . "Likes totales: ". Valoracion::sumaLikes($idUser) . '</p>';
    $html .= '</div>';
    return $html;
}

function generaMediaValoraciones($idProfesor)
{
    $html = '<div class="media-valoraciones">';
    $html .= '<p class="media-valoraciones">' . "media: " . Valoracion::mediaValoracionesProfesor($idProfesor) . '</p>';
    $html .= '</div>';
    return $html;
}

function generaPuntuacion($puntuacion)
{
    $html = '';
    for ($i = 0; $i < $puntuacion; $i++) {
        $html .= '⭐';
    }
    return $html;
}

function botonLike($origen, $id, $likes)
{
    $valor = 1;
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/vistas/helpers/api_likes.php');
    return Formulario::buildButtonForm(
        $api,
        ['url' => $origen, 'id' => $id, 'likes' => $likes, 'valor' => $valor],
        'like',
        '👍'
    );
}

function botonDislike($origen, $id, $likes)
{
    $valor = -1;
    $app = Aplicacion::getInstance();
    $api = $app->resuelve('/includes/vistas/helpers/api_likes.php');
    return Formulario::buildButtonForm(
        $api,
        ['url' => $origen, 'id' => $id, 'likes' => $likes, 'valor' => $valor],
        'dislike',
        '👎'
    );
}

function botonesPaginacion($url, $pagina = 1, $masPaginas = false)
{
    $html = '<div class="botones-paginacion">';
    if ($pagina > 1) {
        $urlN = Aplicacion::getInstance()->buildURL($url, ['pag' => $pagina - 1]);
        $html .= '<a class="boton-anterior" href="' . $urlN . '">Anterior</a>';
    }
    if ($masPaginas) {
        $urlN = Aplicacion::getInstance()->buildURL($url, ['pag' => $pagina + 1]);
        $html .= '<a class="boton-siguiente" href="' . $urlN . '">Siguiente</a>';
    }
    $html .= '</div>';
    return $html;
}
?>