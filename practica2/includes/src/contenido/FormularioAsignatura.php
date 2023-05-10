<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\Formulario;
use escoli\Imagen;
use escoli\centros\Facultad;
use escoli\contenido\Profesor;

class FormularioAsignatura extends Formulario
{
    public function __construct($urlRedireccion = '/index.php')
    {
        parent::__construct('formFacultad', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion)]);

    }

    protected function generaCamposFormulario(&$datos)
    {
        $id = $datos['id'] ?? null;
        $nombre = $datos['nombre'] ?? '';
        

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'profesor', 'archivo'], $this->errores, 'span', array('class' => 'error'));

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
                <p>Selecciona uno o varios profesores</p>
                <label for="profesor">Profesor:</label>
                <select id="profesor" name="profesor" multiple>
                    {$this->generaOpcionesProfesores($id)}
                </select>
                {$erroresCampos['profesor']}
            </div>
            <div><button type="submit" name="registro">Registrar</button></div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $idFacultad = $datos['facultad'] ?? '';
        $this->errores = [];
        
        $app = Aplicacion::getInstance();

        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = "El nombre de la asignatura tiene que tener una longitud de al menos 5 caracteres";
        }

        $idProfesores = array();
        $profesores = $datos['profesor'];
        foreach($profesores as $profesor){
            array_push($idProfesores, filter_var($profesor, FILTER_SANITIZE_NUMBER_INT));
        }
        if (!$idProfesores) {
            $this->errores['profesor'] = "Debes seleccionar un/a profesor/a.";
        }

        $id = filter_var($datos['id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        if (count($this->errores) > 0) {return;}

        if($id){
            
            $asignatura = Asignatura::buscaPorId($id);
            Asignatura::crea($asignatura->nombre, $asignatura->idFacultad, $idProfesores, $id);
            
        }
        else{
            $asignatura = Asignatura::buscaPorNombreYFacultad($nombre, $idFacultad);
            if ($facultad) {
                $this->errores[] = "La asignatura ya existe";
            } else {
               Asignatura::crea($nombre, $idFacultad, $idProfesores);
            }
        }
    }

    private function generaOpcionesProfesores($id)
    {
        $profesores = Profesor::buscaProfesores();
        $html = '';
        $profesoresA = Profesor::buscaProfesoresAsignatura($id);
        foreach ($profesores as $profesor) {
            $selected =  array_search($profesor, $profesoresA) ? 'selected' : '';
            $html .= '<option value="' . $profesor->id . '" ' . $selected . '>' . $profesor->nombre . '</option>';
        }
        return $html;
    }
}

?>