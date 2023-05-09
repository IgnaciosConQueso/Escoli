<?php
require_once __DIR__ . '/includes/config.php';

use escoli\Aplicacion;
use escoli\centros\Facultad;
use escoli\centros\Universidad;
use escoli\contenido\Asignatura;
use escoli\contenido\Profesor;

$app = Aplicacion::getInstance();

$busqueda = $_GET['busqueda'];
$busqueda = filter_var($busqueda, FILTER_SANITIZE_STRING);
$busqueda = filter_var($busqueda, FILTER_SANITIZE_SPECIAL_CHARS);

$tituloPagina = "Buscando: " . $busqueda . "...";

$html = "";

//profesores, asignaturas, facultades, universidades, usuarios
$resultado = false;
$algunResultado = false;
for($i = 0; $i < 4; $i++){//por implementar usuarios: $i < 5
    switch ($i) {
        case 0:
            $resultado = Profesor::buscaPorNombre($busqueda);
            if($resultado){
                $algunResultado = true;
                $html .= "<h1>Profesores</h1>";
                foreach($resultado as $profesor){
                    $html .= "<a href='" . $app->resuelve('perfilProfesor.php?id=' . $profesor->id) . "'>" . $profesor->nombre . "</a>";
                }
            }
        break;
        case 1:
            $resultado = Asignatura::buscaPorNombre($busqueda);
            if($resultado){
                $algunResultado = true;
                $html .= "<h1>Asignaturas</h1>";
                foreach($resultado as $asignatura){
                    $html .= "<a href='" . $app->resuelve('asignatura.php?idAsignatura=' . $asignatura->id) . "'>" . $asignatura->nombre . "</a>";
                }
            }
        break;
        case 2:
            $resultado = Facultad::buscaPorNombre($busqueda);
            if($resultado){
                $algunResultado = true;
                $html .= "<h1>Facultades</h1>";
                foreach($resultado as $facultad){
                    $html .= "<a href='" . $app->resuelve('valoraciones.php?idFacultad=' . $facultad->id) . "'>" . $facultad->nombre . "</a>";
                }
            }
        break;
        case 3:
            $resultado = Universidad::buscaPorNombre($busqueda);
            if($resultado){
                $algunResultado = true;
                $html .= "<h1>Universidades</h1>";
                foreach($resultado as $universidad){
                    $html .= "<a href='" . $app->resuelve('facultades.php?idUniversidad=' . $universidad->id) . "'>" . $universidad->nombre . "</a>";
                }
            }
        break;
        /*case 4:
        break;*/
        default: break;
    }
}

if($algunResultado){
    $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $html];
    $app->generaVista('/plantillas/plantillaPrincipal.php', $params);
} else {
    $app->paginaError(403, 'Error', 'Oops', 'No se han encontrado resultados para la búsqueda');
}
?>