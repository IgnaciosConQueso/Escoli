<?php
namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\contenido\Valoracion;
use escoli\Formulario;
use escoli\contenido\Asignatura;

class FormularioValoracion extends Formulario
{
    public function __construct($urlRedireccion = '/index.php')
    {
        parent::__construct('formValoracion', ['urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion)]);
    }

    protected function generaCamposFormulario(&$datos)
    {

        $idFacultad = $datos['idFacultad'];
        $idAsignatura = $datos['profesorAsignatura'] ?? '';
        $puntuacion = $datos['puntuacion'] ?? '';
        $comentario = $datos['comentario'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['facultad', 'profesor', 'asignatura', 'comentario', 'puntuacion'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Valora a tu profe</legend>
            <div>
                <label for="profesor">Profesor:</label>
                <select id="profesorAsignatura" name="profesorAsignatura">
                    <option value="0">Selecciona un profesor y asignatura</option>
                    {$this->generaOpcionesAsignaturas($idFacultad, $idAsignatura)}
                </select>
                {$erroresCampos['profesor']}
            </div>
                <label for="puntuacion">Puntuación:</label>
                <input id="puntuacion" list="puntuaciones" type="range" min="1" max="5" step="1" name="puntuacion" value="$puntuacion" />
                <datalist id="puntuaciones">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </datalist>
                <span id="validPuntuacion"></span>
                {$erroresCampos['puntuacion']}
            </div>
            <div>
            <label for="comentario">Comentario:</label>
                <input id="comentario" type="text" name="comentario" value="$comentario" />
                <span id="validComentario"></span>
                {$erroresCampos['comentario']}
            </div>
                <button type="submit" name="registro">Publicar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $app = Aplicacion::getInstance();

        $idUsuario = $app->idUsuario();
        $datos['profesorAsignatura'] = explode(',', $datos['profesorAsignatura']);
        $idProfesor = filter_var($datos['profesorAsignatura'][0], FILTER_SANITIZE_NUMBER_INT);
        $idAsignatura = filter_var($datos['profesorAsignatura'][1], FILTER_SANITIZE_NUMBER_INT);
        $puntuacion = filter_var($datos['puntuacion'], FILTER_SANITIZE_NUMBER_INT);
        $comentario = filter_var($datos['comentario'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$idProfesor) {
            $this->errores['profesorAsignatura'] = "Debes seleccionar un profesor";
        }
        if (!$idAsignatura) {
            $this->errores['profesorAsignatura'] = "Debes seleccionar una asignatura";
        }
        if (mb_strlen($comentario) > 1000) {
            $this->errores['comentario'] = "El comentario no puede superar los 1000 caracteres";
        }
        if (mb_strlen($comentario) <= 0) {
            $this->errores['comentario'] = "El comentario no puede estar vacío";
        }

        if (count($this->errores) > 0) {return;}

        Valoracion::crea($idUsuario, $idProfesor, $idAsignatura, $comentario, $puntuacion);
    }

    private function generaOpcionesAsignaturas($idFacultad, $idAsignatura)
    {
        $html = '';
        $asignaturas = Asignatura::buscaAsignaturasPorIdFacultad($idFacultad);
        foreach ($asignaturas as $asignatura) {
            $idA = $asignatura->id;
            $nombreA = $asignatura->nombre;
            $selected = ($idA == $idAsignatura) ? 'selected' : '';

            $profesores = Profesor::buscaProfesoresAsignatura($idA);
            foreach ($profesores as $profesor) {
                $idP = $profesor->id;
                $nombreP = $profesor->nombre;
                $html .= "<option value='$idP,$idA' $selected>" . $nombreP . " - " . $nombreA . "</option>";
            }
        }
        return $html;
    }
}

?>