<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\Formulario;
use escoli\centros\Universidad;
use escoli\centros\Facultad;

class FormularioFacultad extends Formulario
{

    public function __construct()
    {
        parent::__construct('formFacultad', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $iduniversidad = $datos['universidad'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'universidad'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Facultad</legend>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="universidad">Universidad:</label>
                <select id="universidad" name="universidad">
                    <option value="">Selecciona una universidad</option>
                    {$this->generaOpcionesUniversidades($iduniversidad)}
                </select>
                {$erroresCampos['universidad']}
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
            $this->errores['nombre'] = "El nombre de la facultad tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $iduniversidad = filter_var($datos['universidad'], FILTER_SANITIZE_NUMBER_INT);
        if (!$iduniversidad) {
            $this->errores['universidad'] = "La universidad no es válida.";
        }

        if (count($this->errores) === 0) {
            $facultad = Facultad::buscaPorNombre($nombre);
            if ($facultad) {
                $this->errores[] = "La facultad ya existe.";
            } else {
                $facultad = Facultad::crea($nombre, $iduniversidad);
            }
        }
    }

    protected function generaOpcionesUniversidades($iduniversidad)
    {
        $html = '';
        $universidades = Universidad::buscaUniversidades();
        foreach ($universidades as $universidad) {
            $selected = $iduniversidad == $universidad->id ? 'selected' : '';
            $html .= '<option value="' . $universidad->id . '" ' . $selected . '>' . $universidad->nombre . '</option>';
        }
        return $html;
    }

}

?>