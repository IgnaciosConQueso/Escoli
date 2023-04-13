<?php

//expongo solo esta parte del codigo php para no tener que cargar toda la clase en el script.
require 'Valoracion.php';
use escoli\contenido\Valoracion;

$id = $_POST['id'];
$likes = $_POST['likes'];
$valoracion = Valoracion :: gestionaLikes($id,$likes);

