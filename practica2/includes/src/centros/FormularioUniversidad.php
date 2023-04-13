<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;
use escoli\Formulario;

class FormularioUniversidad extends Formulario
{
    public function __construct()
    {
        parent::__construct('formUniversidad', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? null;
        $id = $datos['id'] ?? null;

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Universidad</legend>
            <div>
                <input type="hidden" name="id" value="$id" />
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div><button type="submit" name="registro">Registrar</button></div>
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

        $id = filter_var($datos['id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        if (count($this->errores) > 0) {return;}

        if ($id) { 
            Universidad::crea($nombre, $id);
        } 
        else {
            $universidad = Universidad::buscaPorNombre($nombre);
            if ($universidad) {
                $this->errores[] = "La universidad ya existe.";
            } else {
                $universidad = Universidad::crea($nombre);
            }
        }
        
    }

}

?>