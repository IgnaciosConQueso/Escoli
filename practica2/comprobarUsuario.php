<?php
    //comprobacion en la base de datos que el user existe
    require_once __DIR__ . '/includes/config.php';

    use escoli\usuarios\Usuario;

	$usuario = $_GET['user'];
	$usuario = filter_var($usuario, FILTER_SANITIZE_SPECIAL_CHARS);

    $response = "false";
    
    $existe = Usuario::buscaUsuario($usuario);

    if($existe != false){
        $response = "true";
    }

    echo $response;

    return;
?>