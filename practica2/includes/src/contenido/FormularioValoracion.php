<?php
namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\contenido\Valoracion;
use escoli\Formulario;
use escoli\contenido\Profesor;

class FormularioValoracion extends Formulario
{
    public function __construct() {
        parent::__construct('formValoracion', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['comentario', 'puntuacion'], $this->errores, 'span', array('class' => 'error'));

        $idFacultad = $datos['facultad'] ?? '';
        $idProfesor = $datos['profesor'] ?? '';
        $nombre = $datos['nombre'] ?? '';

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Valora a tu profe</legend>
            <div>
                <label for="profesor">Profesor:</label>
                <select id="profesor" name="$nombre">n
                    <option value="">Selecciona un profesor</option>
                    {$this->generaOpcionesProfesores($idFacultad, $idProfesor)}
                </select>
                {$erroresCampos['profesor']}
            <div>
                <label for="puntuacion">Puntuación:</label>
                <input id="puntuacion" type="text" name="puntuacion" value="$datos.['puntuacion']" />
                {$erroresCampos['puntuacion']}
            </div>
            <div>
            <label for="comentario">Comentario:</label>
                <input id="comentario" type="text" name="comentario" value="$datos.['comentario']" />
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

        $idUsuario=$app->idUsuario();
        $idProfesor=$datos['Profesor'];
        $puntuacion=$datos['puntuacion'];
        $comentario=$datos['comentario'];

        if($puntuacion > 5 || $puntuacion < 1){
            $this->errores[] = "La puntuación debe estar entre 1 y 5";
        }
        if(!$comentario){
            $this->errores[] = "El comentario no puede estar vacío";
        }

        $valoracion=Valoracion::crea($idUsuario, $idProfesor, $comentario ,$puntuacion);
    }

    private function generaOpcionesProfesores($idFacultad, $idProfesor){
        $html = '';
        $profesores = Profesor::buscaProfesoresPorIdFacultad($idFacultad);
        foreach($profesores as $profesor){
            $selected = $profesor->id() == $idProfesor ? 'selected' : '';
            $html .= '<option value="' . $profesor->id() . '" ' . $selected . '>' . $profesor->nombre() . '</option>';
        }
        return $html;
    }
}

?>