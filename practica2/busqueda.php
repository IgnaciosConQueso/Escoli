<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/vistas/helpers/valoracionesHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/asignaturasHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/profesoresHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/facultadesHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/universidadesHelper.php';
require_once __DIR__ . '/includes/vistas/helpers/usuariosHelper.php';


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

$contenidoPrincipal = "<h1>".$tituloPagina."</h1>";


$resultado = false;
$algunResultado = false;
    //profesor
    $resultado = Profesor::buscaPorNombreSimilar($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h3>Profesores</h3>";
        $contenidoPrincipal .= listaProfesoresBusqueda($resultado);
    }

    //asignatura
    $resultado = Asignatura::buscaPorNombreSimilar($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h3>Asignaturas</h3>";
        $contenidoPrincipal .= listaAsignaturasBusqueda($resultado);
    }

    //facultad
    $resultado = Facultad::buscaPorNombreSimilar($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h3>Facultades</h3>";
        $contenidoPrincipal .= listaFacultadesBusqueda($resultado);
    }

    //universidad
    $resultado = Universidad::buscaPorNombreSimilar($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h3>Universidades</h3>";
        $contenidoPrincipal .= listaUniversidadesBusqueda($resultado);
    }
    
    //usuario
    $resultado = Usuario::buscaPorNombreSimilar($busqueda);
    if($resultado){
        $algunResultado = true;
        $contenidoPrincipal .= "<h3>Usuarios</h3>";
        $contenidoPrincipal .= listaUsuariosBusqueda($resultado);
    }

if($algunResultado){
    $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
    $app->generaVista('/plantillas/plantillaPrincipal.php', $params);
} else {
    $app->paginaError(403, 'Error', 'Oops', 'No se han encontrado resultados para la búsqueda');
}
?>