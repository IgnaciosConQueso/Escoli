<?php
namespace escoli\Usuarios;

use escoli\Aplicacion;
use escoli\Formulario;

class FormularioValoracion extends Formulario
{
    public function __construct() {
        parent::__construct('formValoracion', ['action' =>  Aplicacion::getInstance()->resuelve('/publicaValoracion.php'),'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

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
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $idUsuario=$datos['idUsuario'];
        $idProfesor=$datos['idProfesor'];
        $puntuacion=$datos['puntuacion'];
        $comentario=$datos['comentario'];

        
    }
}

?>