<?php
require_once __DIR__ . '/includes/config.php';

use escoli\Aplicacion;
use escoli\centros\Facultad;
use escoli\centros\Universidad;
use escoli\contenido\Asignatura;
use escoli\contenido\Profesor;
use escoli\usuarios\Usuario;

$app = Aplicacion::getInstance();

$busqueda = $_GET['busqueda'];
$busqueda = filter_var($busqueda, FILTER_SANITIZE_SPECIAL_CHARS);

$tituloPagina = "Buscando: " . $busqueda . "...";

$contenidoPrincipal = "";


$resultado = false;
$algunResultado = false;

//profesor
    $resultado = Profesor::buscaPorNombre($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h1>Profesores</h1>";
        foreach($resultado as $profesor){
            $contenidoPrincipal .= "<a href='" . $app->resuelve('perfilProfesor.php?id=' . $profesor->id) . "'>" . $profesor->nombre . "</a>";
        }
    }

    //asignatura
    $resultado = Asignatura::buscaPorNombre($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h1>Asignaturas</h1>";
        foreach($resultado as $asignatura){
            $contenidoPrincipal .= "<a href='" . $app->resuelve('asignatura.php?idAsignatura=' . $asignatura->id) . "'>" . $asignatura->nombre . "</a>";
        }
    }

    //facultad
    $resultado = Facultad::buscaPorNombre($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h1>Facultades</h1>";
        foreach($resultado as $facultad){
            $contenidoPrincipal .= "<a href='" . $app->resuelve('valoraciones.php?idFacultad=' . $facultad->id) . "'>" . $facultad->nombre . "</a>";
        }
    }

    //universidad
    $resultado = Universidad::buscaPorNombre($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h1>Universidades</h1>";
        foreach($resultado as $universidad){
            $contenidoPrincipal .= "<a href='" . $app->resuelve('facultades.php?idUniversidad=' . $universidad->id) . "'>" . $universidad->nombre . "</a>";
        }
    }
    
    //usuario
    $resultado = Usuario::buscaUsuario($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h1>Usuarios</h1>";
        foreach($resultado as $usuario){
            $contenidoPrincipal .= "<a href='" . $app->resuelve('perfilUsuario.php?id=' . $usuario->id) . "'>" . $usuario->nombre . "</a>";
        }
    }

if($algunResultado){
    $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
    $app->generaVista('/plantillas/plantillaPrincipal.php', $params);
} else {
    $app->paginaError(403, 'Error', 'Oops', 'No se han encontrado resultados para la búsqueda');
}
?>