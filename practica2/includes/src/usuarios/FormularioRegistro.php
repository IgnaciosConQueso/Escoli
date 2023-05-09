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
                <span id="validName"></span>
                {$erroresCampos['nombreUsuario']}
            </div>
            
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="$email" />
                <span id = "validEmail"></span>
                {$erroresCampos['email']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                <span id="validPass"></span>
                {$erroresCampos['password']}
            </div>
            
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                <span id = "validPass2"></span>
                {$erroresCampos['password2']}
            </div>
            
            <div>
                <label for="archivo">Foto de Perfil: <input type="file" name="archivo" id="archivo" /></label>
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
        if ($_FILES['archivo']['error'] != UPLOAD_ERR_NO_FILE){
            if ($_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1) {
                $imagen = self :: procesaImagen('usuarios');
            } else {
                $this->errores['archivo'] = "Error al subir el archivo";
            }
        } else {
            $imagen = null;
        }
        
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || mb_strlen($nombreUsuario) < 5) {
            $this->errores['nombreUsuario'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres";
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = ($email === '') ? null : filter_var($email, FILTER_VALIDATE_EMAIL);
        if ( ! $email) {
            $this->errores['email'] = "Introduce un correo válido";
        }

        $password = trim($datos['password'] ?? '');
        $password = ($password === '') ? null : filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = "El password tiene que tener una longitud de al menos 5 caracteres";
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = ($password2 === '') ? null : filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( $password != $password2 ) {
            $this->errores['password2'] = "Los passwords deben coincidir";
        }

       
        if ((count($this->errores)) == 0) {
            $usuario = (Usuario::buscaUsuario($nombreUsuario));

            if($usuario){
                $this->errores['nombreUsuario'] = "Este nombre de usuario ya está en uso";
            } else {
                $usuario = (Usuario::buscaPorEmail($email));
                if ($usuario) {
                    $this->errores['email'] = "Este email ya está en uso";
                } else {
                    if ($imagen) $usuario = Usuario::crea($nombreUsuario, $password, $email, $imagen->id);
                    else $usuario = Usuario::crea($nombreUsuario, $password, $email, null);
                    $app = Aplicacion::getInstance();
                    $app->login($usuario);
                    $app->redirige($app->resuelve('/index.php'));
                }
            }
        }
    }
}
