<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;
use escoli\Formulario;

class FormularioBorrarUniversidad extends Formulario
{
    public function __construct()
    {
        parent::__construct('formBorraUniversidad', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre'], $this->errores, 'span', array('class' => 'error'));


        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Universidad</legend>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div><button type="submit" name="borrar">borrar</button></div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = "El nombre de la universidad tiene que tener una longitud de al menos 5 caracteres.";
        }

        if (count($this->errores) === 0) {
            $universidad = Universidad::buscaPorNombre($nombre);

            if ($universidad) {
                $universidad = Universidad::borra($universidad); 
            } else {
                $this->errores[] = "La universidad a borrar no existe.";
            }
        }
    }

}

?>