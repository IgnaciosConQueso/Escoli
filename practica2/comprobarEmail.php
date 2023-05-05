<?php
    //comprobacion en la base de datos que el email existe
    require_once __DIR__ . '/includes/config.php';

    use escoli\usuarios\Usuario;

	$mail = $_GET['email'];
	$mail = filter_var($mail, FILTER_SANITIZE_SPECIAL_CHARS);
    $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

    $response = "false";
    
    $existe = Usuario::buscaPorEmail($mail);

    if($existe != false){
        $response = "true";
    }

    echo $response;

    return;
?>