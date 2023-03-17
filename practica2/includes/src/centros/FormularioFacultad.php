<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;
use escoli\Formulario;

class FormularioFacultad extends Formulario
{

    public function __construct()
    {
        parent::__construct('formFacultad', ['urlRedireccion' => 'facultades.php']);
    }

}

?>