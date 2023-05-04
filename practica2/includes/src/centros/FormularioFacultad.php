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
    public function __construct()
    {
        parent::__construct('formFacultad', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);

    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $iduniversidad = $datos['universidad'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'universidad', 'archivo'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Facultad</legend>
            <div>
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
         $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
         if (! $ok ) {
             $this->errores['archivo'] = 'Error al subir el archivo';
             return;
         } 
         
         $nombre = $_FILES['archivo']['name'];
         /* 1.a) Valida el nombre del archivo */
         $ok = self::check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre);
 
         /* 1.b) Sanitiza el nombre del archivo (elimina los caracteres que molestan)
         $ok = self::sanitize_file_uploaded_name($nombre);
         */
 
         /* 1.c) Utilizar un id de la base de datos como nombre de archivo */
         // Vamos a optar por esta opción que es la que se implementa más adelante
 
         /* 2. comprueba si la extensión está permitida */
         $extension = pathinfo($nombre, PATHINFO_EXTENSION);
         $ok = $ok && in_array($extension, self::EXTENSIONES_PERMITIDAS);
 
         /* 3. comprueba el tipo mime del archivo corresponde a una imagen image/* */
         $finfo = new \finfo(FILEINFO_MIME_TYPE);
         $mimeType = $finfo->file($_FILES['archivo']['tmp_name']);
         $ok = preg_match('/image\/*./', $mimeType);
 
         if (!$ok) {
             $this->errores['archivo'] = 'El archivo tiene un nombre o tipo no soportado';
         }
 
         if (count($this->errores) > 0) {
             return;
         }
 
         $tmp_name = $_FILES['archivo']['tmp_name'];
 
         $imagen = Imagen::crea($nombre, $mimeType, '');
         $imagen->guarda();
         $fichero = "{$imagen->getId()}.{$extension}";
         $imagen->setRuta('\facultades\\'.$fichero);
         $imagen->guarda();
         $ruta = implode(DIRECTORY_SEPARATOR, [RUTA_IMGS.'\facultades', $fichero]);
         if (!move_uploaded_file($tmp_name, $ruta)) {
             $this->errores['archivo'] = 'Error al mover el archivo';
         }
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = "El nombre de la facultad tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $iduniversidad = filter_var($datos['universidad'], FILTER_SANITIZE_NUMBER_INT);
        if (!$iduniversidad) {
            $this->errores['universidad'] = "Debes seleccionar una universidad.";
        }

        if (count($this->errores) === 0) {
            $facultad = Facultad::buscaPorNombre($nombre);
            if ($facultad) {
                $this->errores[] = "La facultad ya existe.";
            } else {
                $facultad = Facultad::crea($nombre, $iduniversidad, $imagen->getId());
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
     /**
     * Check $_FILES[][name]
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private static function check_file_uploaded_name($filename)
    {
        return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i', $filename) === 1) ? true : false);
    }

    /**
     * Sanitize $_FILES[][name]. Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     *
     * If you don't need to handle multi-byte characters you can use preg_replace
     * rather than mb_ereg_replace.
     * 
     * @param (string) $filename - Uploaded file name.
     * @author Sean Vieira
     * @see http://stackoverflow.com/a/2021729
     */
    private static function sanitize_file_uploaded_name($filename)
    {
        /* Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     * If you don't need to handle multi-byte characters
     * you can use preg_replace rather than mb_ereg_replace
     * Thanks @Łukasz Rysiak!
     */
        $newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        // Remove any runs of periods (thanks falstro!)
        $newName = mb_ereg_replace("([\.]{2,})", '', $newName);

        return $newName;
    }

    /**
     * Check $_FILES[][name] length.
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz.
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private function check_file_uploaded_length($filename)
    {
        return (bool) ((mb_strlen($filename, 'UTF-8') < 250) ? true : false);
    }
}

?>