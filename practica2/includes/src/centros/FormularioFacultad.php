<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\Formulario;
use escoli\Imagen;
use escoli\centros\Universidad;
use escoli\centros\Facultad;

class FormularioFacultad extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');
    public function __construct($urlRedireccion = '/index.php')
    {
        parent::__construct('formFacultad', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion)]);

    }

    protected function generaCamposFormulario(&$datos)
    {
        $id = $datos['id'] ?? null;
        $nombre = $datos['nombre'] ?? '';
        $iduniversidad = $datos['universidad'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'universidad', 'archivo'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Facultad</legend>
            <div>
                <input type="hidden" name="id" value="$id" />
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                <span id="validName"></span>
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="universidad">Universidad:</label>
                <select id="universidad" name="universidad">
                    <option value="0">Selecciona una universidad</option>
                    {$this->generaOpcionesUniversidades($iduniversidad)}
                </select>
                {$erroresCampos['universidad']}
            </div>
            <div>
                <label for="archivo">Archivo: <input type="file" name="archivo" id="archivo" /></label>
                {$erroresCampos['archivo']}
            </div>
            <div><button type="submit" name="registro">Registrar</button></div>
        </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $app = Aplicacion::getInstance();

        $this->errores = [];
        // Verificamos que la subida ha sido correcta
        if ($_FILES['archivo']['error'] != UPLOAD_ERR_NO_FILE){
            if ($_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1) {
                $imagen = self :: procesaImagen('centros');
            } else {
                $this->errores['archivo'] = "Error al subir el archivo";
            }
        } else {
            $imagen = null;
        }

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = "El nombre de la facultad tiene que tener una longitud de al menos 5 caracteres";
        }
        
        $iduniversidad = filter_var($datos['universidad'], FILTER_SANITIZE_NUMBER_INT);
        if (!$iduniversidad) {
            $this->errores['universidad'] = "Debes seleccionar una universidad.";
        }

        $id = filter_var($datos['id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        if (count($this->errores) > 0) {return;}

        if($id){
            if($imagen){Facultad::crea($nombre, $iduniversidad, $imagen->id, $id);}
            else{
                $facultad = Facultad::buscaPorId($id);
                Facultad::crea($nombre, $iduniversidad, $facultad->imagen->id, $id);
            }
        }
        else{
            $facultad = Facultad::buscaPorNombreYUniversidad($nombre, $iduniversidad);
            if ($facultad) {
                $this->errores[] = "La facultad ya existe";
            } else {
                if($imagen) Facultad::crea($nombre, $iduniversidad, $imagen->id);
                else Facultad::crea($nombre, $iduniversidad);
            }
        }
    }

    private function generaOpcionesUniversidades($iduniversidad)
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