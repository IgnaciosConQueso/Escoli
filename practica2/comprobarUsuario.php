<?php
    use escoli\usuarios\Usuario;

    //comprobacion en la base de datos que el user existe
	$usuario = $_GET['user'];
	$usuario = filter_var($usuario, FILTER_SANITIZE_SPECIAL_CHARS);

    $response = "false";
    
    $existe = Usuario::buscaUsuario($usuario);

    if($existe){
        $response = "true";
    }

    echo $response;

    return;
?>