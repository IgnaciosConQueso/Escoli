<?php
require_once 'includes/config.php';
$tituloPagina = 'Miembros';
$contenidoPrincipal = <<<EOS
        <h2> MIEMBROS DEL EQUIPO</h2>
        <p>
            Somos un grupo de desarrollo serio pero con un ambiente de trabajo jovial. Nuestros métodos de trabajo
            favoritos son el crunch y el scrum como toda gran empresa que se precie. Los cinco estamos comprometidos 
            con la causa y estamos más que preparados e ilusionados para afrontar este proyecto con toda la fuerza de 
            una hormiga.
        </p>
        <h3> Lista de Miembros: </h3>
        <ul>
            <li><a href = "#limon">Guillermo Lemonnier</a> guilemon@ucm.es </li>
            <li><a href = "#luque">Alejandro Luque Villegas</a> aluqe02@ucm.es </li>
            <li><a href = "#pablo">Pablo Garcia Fernandez</a> pagarc24@ucm.es </li>
            <li><a href = "#jorbis">Javier Orbis Ramirez</a> jorbis@ucm.es</li>
            <li><a href = "#nacho">Ignacio Sanchez Santatecla</a> ignsan@ucm.es</li>
        </ul>
        
        <dl>
            <dt id = "limon">
                <a href = "https://github.com/Lem0z3n"><img class = "fotoperfil" src="imagenes/usuarios/limonpp.JPG" alt ="githubGuille" title = "githubGuille"><u class = "nombrePropio">Guillermo "limón" Lemonnier:</u></a>
            </dt>
            <dd>
                <p> Soy un chico alegre que disfruta de los paseos en la playa, jugar al rugby y sacar buenas notas en clase de sistemas web. <mark> guilemon@ucm.es </mark></p>
                
            </dd>
            <dt id = "luque">
            <a href = "https://github.com/aluque1"> <img class = "fotoperfil" src="imagenes/usuarios/luquepp.jpg" alt = "githubLuque" title = "githubLuque"><u class = "nombrePropio" >Alejandro "luque" Luque: </u> </a>
            </dt>
            <dd>
            <p>A mi me gusta hacer macrame, el punto de cruz y jugar al volleyball. Mis intereses son el teatro eslavo y el cine de epoca marroquí. <mark> aluqe02@ucm.es </mark></p>
            </dd>
            <dt id = "jorbis">
                <a  href = "https://github.com/Jorbis21"><img class = "fotoperfil" src ="imagenes/usuarios/orbispp.jpg" alt ="githubOrbis" title = "githubOrbis"><u class = "nombrePropio" >Javier "jorbis" Orbis:</u></a>
            </dt>
            <dd>
                <p> Me gusta leer y jugar videojuegos. <mark> jorbis@ucm.es </mark></p>
            </dd>
            <dt id = "pablo">
                <a  href = "https://github.com/pagarc24"><img class = "fotoperfil" src ="imagenes/usuarios/pablopp.jpg" alt = "githubPablo" title = "githubPablo"><u class = "nombrePropio" >Pablo "español" García:</u></a>        
            </dt>
            <dd>
                <p> Me gusta escuchar música, jugar al futbol y quedar con mis amigos en el parque. <mark> pagarc24@ucm.es </mark> </p>
            </dd>
            <dt id = "nacho">
                <a href = "https://github.com/Nachoski08"><img class = "fotoperfil" src ="imagenes/usuarios/nachopp.jpg" alt = "githubNacho" title = "githubNacho"><u class = "nombrePropio" >Ignacio "Nacho" Sánchez:</u></a>
            </dt>
            <dd>
            <p> Disfruto de los deportes de riesgo como los saltos de motos, además participo en mi tiempo libre en ayudar a los desfavorecidos en un centro de desintoxicación de menores y adopto perros ciegos y cojos. <mark> ignsan@ucm.es </mark></p> 
            </dd>
            <dd>
            <p> Mención a Elisa Santamarina Castaño que es la diseñadora del logo y las imagenes de la cabecera, incluyendo las fotos, </p>
            </dd>
        </dl>
EOS;
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaPrincipal.php', $params);

?>