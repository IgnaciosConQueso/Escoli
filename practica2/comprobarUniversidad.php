<?php
    //comprobacion en la base de datos que la universidad existe
    require_once __DIR__ . '/includes/config.php';

    use escoli\centros\Universidad;

	$universidad = $_GET['universidad'];
	$universidad = filter_var($universidad, FILTER_SANITIZE_SPECIAL_CHARS);

    $response = "false";
    
    $existe = Universidad::buscaPorNombre($universidad);

    if($existe != false){
        $response = "true";
    }

    echo $response;

    return;
?>