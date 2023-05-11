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
                <input id="pregunta" type="text" name="pregunta" value="$pregunta"/>
                <span id="validPregunta"></span>
                {$erroresCampos['pregunta']}
            </div>
            <div>
                <label for="opcion1">Opcion 1:</label>
                <input id="opcion1" type="text" name="opcion1"  value="$opcion1"/>
                <span id="validOpcion1"></span>
                {$erroresCampos['opciones']}
            </div>
            <div>
                <label for="opcion2">Opcion 2:</label>
                <input id="opcion2" type="text" name="opcion2"  value="$opcion2"/>
                <span id="validOpcion2"></span>
            </div>
            <div>
                <label for="opcion3">Opcion 3:</label>
                <input id="opcion3" type="text" name="opcion3"  value="$opcion3"/>
                <span id="validOpcion3"></span>
            </div>
            {$erroresCampos['opciones']}
            <span id="validOpciones"></span>
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
            $this->errores['opciones'] = "No puede haber opciones vacias";
        } else {
            if ($opcion1 == $opcion2 || $opcion1 == $opcion3 || $opcion2 == $opcion3) {
                $this->errores['opciones'] = "No puede haber opciones iguales";
            }
        }

        if (count($this->errores) > 0) {return;}

        $opciones = array($opcion1, $opcion2, $opcion3);
        Encuesta::crea($idUsuario, $idFacultad, $pregunta, $opciones);
    }
}
?>