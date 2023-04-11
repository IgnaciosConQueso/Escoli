<?php

require_once 'includes/config.php';

$tituloPagina = 'Detalles';
$contenidoPrincipal = <<<EOS
<h3>¿Qué es Escoli?</h3>

<h4>Introduccion</h4>

<p>Escoli es un portal de reseñas donde los usuarios registrados pueden valorar o comentar su experiencia con un profesor determinado.</p>
<p></p>

<h4>¿Qué usuarios hay en este portal?</h4>

<p><b>El estudiante</b> puede solicitar el alta de un profesor, siempre que cumpla unos requisitos, valorar a los profesores en un rango de cinco estrellas y escribir sobre su experiencia en las clases con ese profesor.</p>

<p><b>El moderador</b> puede eliminar opiniones, así como suspender temporal o permanentemente a estudiantes.</p>
    
<p><b>El visitante</b> solo puede visualizar a los profesores junto con sus valoraciones.</p> 
    
<p><b>El administrador</b> puede dar de alta, borrar y modificar profesores. Además tiene la potestad de otorgar y retirar el rol de moderador a los usuarios. También es el encargado de dar de alta, modificar y borrar centros, titulaciones y asignaturas.</p> 
<p></p>

<h4>¿Qué funcionalidades tiene Escoli?</h4>

<p>Las reseñas pueden ser o no anónimas.(<b>Estudiante</b>)</p>

<p>Otra cosa que tiene este portal es la característica de crearse encuestas temporales, para saber que es lo que opinan los usuarios de los centros, asignaturas y profes que esten en nuestra base de datos. (<b>Estudiante, Moderador, Administrador</b>)</p>

<p>Para que sea más fácil localizar a los profesores estos tienen asociados lo centros en los que imparten clase y las asignaturas que dan.</p>

<p>Para poder tener una cuenta en este portal necesitaremos saber en que centro y estudios estas matriculado, aparte de tus datos básicos. (Esto lo necesitamos para que no pongas verde a profesores que no te han dado clase.) (<b>Estudiante</b>)</p>

<p>Las reseñas se pueden destacar a traves de votos positivos o negativos por parte del 
    resto de usuarios. Bien por que les parezca divertido o bien por su utilidad.
    (<b>Estudiante, Moderador, Administrador</b>)</p> 

<p>Hay dos sistemas de puntuaciones que te harán destacar en la plataforma:</p>

<p>El primero esta basado en cuan activo seas en la plataforma, dandote puntos cuando escribas comentarios, respondas a encuestas 
    o votes por la utilidad de comentarios de otros usuarios. Estos puntos te otorgan una serie de privilegios como por ejemplo solicitar el alta de un 
    profesor que no figure en la aplicación.(<b>Estudiante</b>)
</p> 

<p>El segundo esta basado en la relevancia de tus aportaciones, obteniéndose con votos positivos en tus comentarios o en función del 
    número de personas que participen en tus encuestas. Estos puntos se traducirán en un mejor posicionamiento y mayor visibilidad de tus aportaciones.(<b>Estudiante</b>)
</p>
EOS;
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>