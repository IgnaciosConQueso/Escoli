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
            </div>
            <div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
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
            $this->errores[] = "El nombre de la universidad tiene que tener una longitud de al menos 5 caracteres.";
        }

        if (count($this->errores) === 0) {
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