<?php
    use escoli\usuarios\Usuario;

    //comprobacion en la base de datos que el user existe
	$usuario = $_GET['user'];
	$usuario = filter_var($usuario, FILTER_SANITIZE_SPECIAL_CHARS);
    
    $existe = Usuario::buscaUsuario($usuario);

    if($existe){
        echo "true";
        return;
    }
    echo "false";

    
?>