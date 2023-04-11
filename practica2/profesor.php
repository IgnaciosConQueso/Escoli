<?php

require_once 'includes/config.php';

$tituloPagina = 'Escoli';
$contenidoPrincipal = <<<EOS
<form enctype="text/plain" method = "post">
  <h2>Nombre de profesor</h2>
  <section>
    <h4>Reseña</h4>
    <label for="mensaje"></label>
    <textarea id="mensaje" name="mensaje" placeholder="Escribe aquí tu review..." required></textarea>
  </section>
</form>
<button>Publicar</button>
<button>hacer encuesta</button>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>