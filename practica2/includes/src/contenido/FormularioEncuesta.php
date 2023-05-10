<?
namespace escoli\contenido;
use escoli\Aplicacion;
use escoli\Formulario;

class FormularioEncuesta extends Formulario{

    public function __construct(){
        parent::__construct('formEncuesta', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }

    protected function generaCamposFormulario(&$datos){
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['pregunta', 'opciones'], $this->errores, 'span', array('class' => 'error'));
    
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Nueva encuesta</legend>
            <div>
                <label for="pregunta">Pregunta:</label>
                <input id="pregunta" type="text" name="pregunta" />
                <span id="validPregunta"></span>
                {$erroresCampos['pregunta']}
            </div>
            tres opciones
            <div>
                <label for="opciones">Opcion 1:</label>
                <input id="opcion1" type="text" name="opciones" />
                <span id="validOpcion1"></span>
                {$erroresCampos['opciones']}
            </div>
            <div>
                <label for="opciones">Opcion 2:</label>
                <input id="opcion2" type="text" name="opciones" />
                <span id="validOpcion2"></span>
            </div>
            <div>
                <label for="opciones">Opcion 3:</label>
                <input id="opcion3" type="text" name="opciones" />
                <span id="validOpcion3"></span>
            </div>
            <div>
                <button type="submit" name="registro">Publicar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
}
?>