<?php
namespace escoli\usuarios;

use escoli\Aplicacion;
use escoli\Formulario;

class FormularioRegistro extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    const TIPO_ALMACEN = [Imagen::PUBLICA => 'Publico', Imagen::PRIVADA =>'Privado'];

    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    private static function generaSelectorTipoAlmacen($name, $tipoSeleccionado=null, $id=null)
    {
        $id= $id !== null ? "id=\"{$id}\"" : '';
        $html = "<select {$id} name=\"{$name}\">";
        foreach(self::TIPO_ALMACEN as $clave => $valor) {
            $selected='';
            if ($tipoSeleccionado && $clave == $tipoSeleccionado) {
                $selected='selected';
            }
            $html .= "<option value=\"{$clave}\"{$selected}>{$valor}</option>";
        }
        $html .= '</select>';

        return $html;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'password', 'password2', 'archivo', 'tipo'], $this->errores, 'span', array('class' => 'error'));

        $tipoAlmacenSeleccionado = $datos['tipo'] ?? null;
        $selectorTipoAlmacen = self::generaSelectorTipoAlmacen('tipo', $tipoAlmacenSeleccionado, 'tipo');

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
                <label for="archivo">Archivo: <input type="file" name="archivo" id="archivo" /></label>{$erroresCampos['archivo']}
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
        $this->errores = [];

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

        $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
        if (! $ok ) {
            $this->errores['archivo'] = 'Error al subir el archivo';
            return;
        }  

        $nombre = $_FILES['archivo']['name'];

        $tipoAlmacen = $datos['tipo'] ?? Imagen::PUBLICA;

        $ok = array_key_exists($tipoAlmacen, self::TIPO_ALMACEN);
        if (!$ok) {
            $this->errores['tipo'] = 'El tipo del almacén no está seleccionado o no es correcto';
        }

        $ok = self::check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre);

        $extension = pathinfo($nombre, PATHINFO_EXTENSION);
        $ok = $ok && in_array($extension, self::EXTENSIONES_PERMITIDAS);

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['archivo']['tmp_name']);
        $ok = preg_match('/image\/*./', $mimeType);

        if (!$ok) {
            $this->errores['archivo'] = 'El archivo tiene un nombre o tipo no soportado';
        }


        if (count($this->errores) === 0) {
            //no se si aqui hay que añadir algo de la imagen
            $usuario = Usuario::buscaUsuario($nombreUsuario);
	
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } else {
                $usuario = Usuario::crea($nombreUsuario, $password, $email);
                $app = Aplicacion::getInstance();
                $app->login($usuario);
            }
        }

        $tmp_name = $_FILES['archivo']['tmp_name'];

        $imagen = Imagen::crea($nombre, $mimeType, $tipoAlmacen, '');
        $imagen->guarda();
        $fichero = "{$imagen->id}.{$extension}";
        $imagen->setRuta($fichero);
        $imagen->guarda();
        $ruta = implode(DIRECTORY_SEPARATOR, [RUTA_ALMACEN_PUBLICO, $fichero]);
        if ($tipoAlmacen == Imagen::PRIVADA) {
            $ruta = implode(DIRECTORY_SEPARATOR, [RUTA_ALMACEN_PRIVADO, $fichero]);
        }
        if (!move_uploaded_file($tmp_name, $ruta)) {
            $this->errores['archivo'] = 'Error al mover el archivo';
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

