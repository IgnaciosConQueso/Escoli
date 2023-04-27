<?php
namespace escoli\usuarios;

use escoli\Aplicacion;
use escoli\Formulario;
use escoli\Imagen;

class FormularioRegistro extends Formulario
{

    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    public function __construct() {
        parent::__construct('formRegistro', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $email = $datos['email'] ?? '';
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'password', 'password2','archivo'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
                <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" />
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="email">Email:</label>
                <input id="email" type="text" name="email" value="$email" />
                {$erroresCampos['email']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <label for="archivo">Archivo: <input type="file" name="archivo" id="archivo" /></label>
                {$erroresCampos['archivo']}
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
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
         $imagen->setRuta('\usuarios\\'.$fichero);
         $imagen->guarda();
         $ruta = implode(DIRECTORY_SEPARATOR, [RUTA_IMGS.'\usuarios', $fichero]);
         if (!move_uploaded_file($tmp_name, $ruta)) {
             $this->errores['archivo'] = 'Error al mover el archivo';
         }
 
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || mb_strlen($nombreUsuario) < 5) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'Introduce un email válido.';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }

       
        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaUsuario($nombreUsuario);
	
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } else {
                $usuario = Usuario::crea($nombreUsuario, $password, $email);
                $app = Aplicacion::getInstance();
                $app->login($usuario);
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
