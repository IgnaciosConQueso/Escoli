<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;
use escoli\Formulario;
use escoli\Imagen;

class FormularioUniversidad extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    public function __construct($urlRedireccion = '/index.php')
    {
        parent::__construct('formUniversidad', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion)]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? null;
        $id = $datos['id'] ?? null;

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre','archivo'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Universidad</legend>
            <div>
                <input type="hidden" name="id" value="$id" />
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                <span id = "validName"></span>
                {$erroresCampos['nombre']}
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
            $this->errores['nombre'] = "El nombre de la universidad tiene que tener una longitud de al menos 5 caracteres";
        }

        $id = filter_var($datos['id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        if (count($this->errores) > 0) {return;}

        if ($id) { 
            if($imagen) Universidad::crea($nombre, $imagen->id , $id);
            else{
                $universidad = Universidad::buscaPorId($id);
                Universidad::crea($nombre, $universidad->idImagen, $id);
            }
        } 
        else {
            $universidad = Universidad::buscaPorNombre($nombre);
            if ($universidad) {
                $this->errores[] = "La universidad ya existe";
            } else {
                if($imagen) Universidad::crea($nombre, $imagen->id);
                else Universidad::crea($nombre);
            }
        }
        
    }
}

?>