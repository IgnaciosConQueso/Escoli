<?php
namespace escoli\contenido;
use escoli\Aplicacion;
use escoli\Formulario;

class FormularioEncuesta extends Formulario{

    public function __construct($urlRedireccion = '/index.php'){
        parent::__construct('formEncuesta', ['urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion)]);
    }

    protected function generaCamposFormulario(&$datos){
        $pregunta = $datos['pregunta'] ?? '';
        $opcion1 = $datos['opcion1'] ?? '';
        $opcion2 = $datos['opcion2'] ?? '';
        $opcion3 = $datos['opcion3'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['pregunta', 'opciones'], $this->errores, 'span', array('class' => 'error'));
    
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Nueva encuesta</legend>
            <div>
                <label for="pregunta">Pregunta:</label>
                <input id="pregunta" type="text" name="pregunta" value ="$pregunta"/>
                <span id="validPregunta"></span>
                {$erroresCampos['pregunta']}
            </div>
            <div>
                <label for="opciones">Opcion 1:</label>
                <input id="opcion1" type="text" name="opciones"  value ="$opcion1"/>
                <span id="validOpcion1"></span>
                {$erroresCampos['opciones']}
            </div>
            <div>
                <label for="opciones">Opcion 2:</label>
                <input id="opcion2" type="text" name="opciones"  value ="$opcion2"/>
                <span id="validOpcion2"></span>
            </div>
            <div>
                <label for="opciones">Opcion 3:</label>
                <input id="opcion3" type="text" name="opciones"  value ="$opcion3"/>
                <span id="validOpcion3"></span>
            </div>
            <div>
                <button type="submit" name="registro">Publicar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos){
        $this->errores = [];
        $app = Aplicacion::getInstance();
        $idUsuario = $app->idUsuario();
        $pregunta = $datos['pregunta'] ?? null;
        $idFacultad = $datos['idFacultad'];

        $opcion1 = $datos['opcion1'] ?? null;
        $opcion2 = $datos['opcion2'] ?? null;
        $opcion3 = $datos['opcion3'] ?? null;

        if ( !$pregunta ) {
            $this->errores['pregunta'] = "La pregunta no puede estar vacía.";
        }
        if ( !$opcion1 || !$opcion2 || !$opcion3) {
            $this->errores['opciones'] = "Las opciones no pueden estar vacías.";
        }

        if (count($this->errores) > 0) {return;}

        $opciones = array($opcion1, $opcion2, $opcion3);
        Encuesta::crea($idUsuario, $idFacultad, $pregunta, $opciones);
    }
}
?>