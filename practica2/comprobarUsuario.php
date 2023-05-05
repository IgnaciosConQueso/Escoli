<?php
    //comprobacion en la base de datos que el user existe
    require_once __DIR__ . '/includes/config.php';

    use escoli\usuarios\Usuario;

    $response = "false";

    if (isset($_GET['user'])) {
        $usuario = $_GET['user'];
        $usuario = filter_var($usuario, FILTER_SANITIZE_SPECIAL_CHARS);
        $existe = Usuario::buscaUsuario($usuario);
    }
    else{
        $mail = $_GET['email'];
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
        $existe = Usuario::buscaPorEmail($mail);
    }

    if($existe != false){
        $response = "true";
    }

    echo $response;

    return;
?>