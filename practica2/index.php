<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal=<<<EOS
<section class = "center">
<h4>La página donde puedes evaluar a tus profesores.</h4>
<p>Se podrá puntuar a profesores en terminos de labor docente o valor aportado 
    y cada asignatura que imparta tendrá una puntuación distinta. Esta valoración puede ser en 
    forma de comentarios y/o puntuación.</p>
<p>Para que los usuarios esten más dispuestos a dejar reseñas se tiene pensado implementar dos sistemas de puntuaciones.</p>
</section>

<a href= 'universidad.php'>>Busca tu universidad.....</a>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);