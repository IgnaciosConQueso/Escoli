<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;
use escoli\Formulario;
use escoli\Imagen;

class FormularioUniversidad extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    public function __construct()
    {
        parent::__construct('formUniversidad', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'index.php']);
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
         $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
         if (! $ok ) {
             $this->errores['archivo'] = "Error al subir el archivo";
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
             $this->errores['archivo'] = "El archivo tiene un nombre o tipo no soportado";
         }
 
         if (count($this->errores) > 0) {
             return;
         }
 
         $tmp_name = $_FILES['archivo']['tmp_name'];
 
         $imagen = Imagen::crea($nombre, $mimeType, '');
         $imagen->guarda();
         $fichero = "{$imagen->getId()}.{$extension}";
         $imagen->setRuta('\universidades\\'.$fichero);
         $imagen->guarda();
         $ruta = implode(DIRECTORY_SEPARATOR, [RUTA_IMGS.'\universidades', $fichero]);
         if (!move_uploaded_file($tmp_name, $ruta)) {
             $this->errores['archivo'] = "Error al mover el archivo";
         }

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = "El nombre de la universidad tiene que tener una longitud de al menos 5 caracteres";
        }

        $id = filter_var($datos['id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        if (count($this->errores) > 0) {return;}

        if ($id) { 
            Universidad::crea($nombre, $id, $imagen->getId());
        } 
        else {
            $universidad = Universidad::buscaPorNombre($nombre);
            if ($universidad) {
                $this->errores[] = "La universidad ya existe";
            } else {
                $universidad = Universidad::crea($nombre, $imagen->getId());
            }
        }
        
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