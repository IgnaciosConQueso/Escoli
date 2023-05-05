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

        $idFacultad = $datos['idFacultad'];
        $idProfesor = $datos['profesor'] ?? '';
        $puntuacion = $datos['puntuacion'] ?? '';
        $comentario = $datos['comentario'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['profesor', 'comentario', 'puntuacion'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Valora a tu profe</legend>
            <div>
                <label for="profesor">Profesor:</label>
                <select id="profesor" name="profesor">
                    <option value="0">Selecciona un profesor</option>
                    {$this->generaOpcionesProfesores($idFacultad, $idProfesor)}
                </select>
                {$erroresCampos['profesor']}
            <div>
                <label for="puntuacion">Puntuación:</label>
                <input id="puntuacion" type="text" name="puntuacion" value="$puntuacion" />
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

        $idUsuario=$app->idUsuario();
        $idProfesor=filter_var($datos['profesor'], FILTER_SANITIZE_NUMBER_INT);
        $puntuacion=filter_var($datos['puntuacion'], FILTER_SANITIZE_NUMBER_INT);
        $comentario=filter_var($datos['comentario'], FILTER_SANITIZE_SPECIAL_CHARS);

        if($puntuacion > 5 || $puntuacion < 1){
            $this->errores[] = "La puntuación debe estar entre 1 y 5";
        }
        if(mb_strlen($comentario) > 1000){
            $this->errores[] = "El comentario no puede superar los 1000 caracteres";
        }
        if(mb_strlen($comentario) <= 0){
            $this->errores[] = "El comentario no puede estar vacío";
        }
        if(!$idProfesor){
            $this->errores[] = "Debes seleccionar un profesor";
        }

        Valoracion::crea($idUsuario, $idProfesor, $comentario ,$puntuacion);
    }

    private function generaOpcionesProfesores($idFacultad, $idProfesor){
    
        $html = '';
        $profesores = Profesor::buscaProfesoresPorIdFacultad($idFacultad);
        foreach ($profesores as $profesor) {
            $selected = $profesor->id == $idProfesor ? 'selected' : '';
            $html .= '<option value="' . $profesor->id . '" ' . $selected . '>' . $profesor->nombre . '</option>';
        }
        return $html;
    }
    
}

?>