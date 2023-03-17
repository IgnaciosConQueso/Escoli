<?php
namespace escoli\Usuarios;

use escoli\Aplicacion;
use escoli\contenido\Valoracion;
use escoli\Formulario;

class FormularioValoracion extends Formulario
{
    public function __construct() {
        parent::__construct('formValoracion', ['action' =>  Aplicacion::getInstance()->resuelve('/publicaValoracion.php'),'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['comentario', 'puntuacion'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Valora a tu profe</legend>
            <div>
                <label for="comentario">Comentario:</label>
                <input id="comentario" type="text" name="comentario" value="$datos['comentario'] " />
                {$erroresCampos['comentario']}
            </div>
            <div>
                <label for="puntuacion">Puntuación:</label>
                <input id="puntuacion" type="text" name="puntuacion" value="$datos['puntuacion']" />
                {$erroresCampos['puntuacion']}
            <div>
                <button type="submit" name="registro">Publicar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $idUsuario=$datos['idUsuario'];
        $idProfesor=$datos['idProfesor'];
        $puntuacion=$datos['puntuacion'];
        $comentario=$datos['comentario'];

        if($puntuacion>5 || $puntuacion<0){
            $this->errores[] = "La puntuación debe estar entre 0 y 5";
        }
        if(!$comentario){
            $this->errores[] = "El comentario no puede estar vacío";
        }
        $fecha = date("Y-m-d");
        $valoracion=Valoracion::crea($idUsuario, $idProfesor, $fecha, $puntuacion,$comentario);
    }
}

?>