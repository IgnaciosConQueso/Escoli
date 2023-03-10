<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id = "estilo" type="text/css" rel="stylesheet" href="tabla.css"/>
    <title>Planificación</title>
</head>
<body>
   
  <?php include 'cabecera.html' ?>


    <h2>Planificación de tareas</h2>

        <table>
            <caption>Hitos</caption>
            <tr>
                <th>Tarea</th>
                <th>Fecha</th>
                <th>Completado</th>
            </tr>
            <tr>
                <td>Etapa 0</td>
                <td>8 de febrero</td>
                <td>Sí</td>
            </tr>
            <tr>
                <td>Práctica 1</td>
                <td>22 de febrero</td>
                <td>No</td>
            </tr>
            <tr>
                <td>Práctica 2</td>
                <td>23 de marzo</td>
                <td>No</td>
            </tr>
            <tr>
                <td>Práctica 3</td>
                <td>13 de abril</td>
                <td>No</td>
            </tr>
            <tr>
                <td>Entrega final</td>
                <td>5 de mayo</td>
                <td>No</td>
            </tr>
        </table>

    <section>
        <h3>Descripción de los hitos</h3>
        
        <h4>Etapa 0</h4>
        <p>
            En esta primera etapa se creo el grupo del proyecto. Tuvo como objetivo el hacer una propuesta de la idea del
            proyecto y presentarselo al profe para discutir las distintas funcionalidades que pudiera tener el mismo.
        </p>

        <h4>Práctica 1</h4>
        <p>
            El grupo debe desarrollar una descripción del proyecto en forma de página web simple.
            Esta misma web incluye las siguientes páginas:
        </p>
            <dl>
                <dt>Bocetos</dt>
                    <dd>Incluye bocetos de como será el visual de la aplicación web</dd>
                <dt>Contacto</dt>
                    <dd>Incluye un pequeño formulario que permite al usuario hacer preguntas, 
                        críticas o sugerencias a los desarrolladores</dd>
                <dt>Detalles</dt>
                    <dd>Incluye una extensa explicación del objetivo del proyecto: que funcionalidades
                        va a tener, a que público está dirigido, etc.
                    </dd>
                <dt>Miembros</dt>
                    <dd>Incluye una breve introducción de cada uno de los miembros del grupo</dd>
                <dt>Planificación</dt>
                    <dd>Esta misma página. Incluye datos sobre las distintas etapas que tendrá el desarrollo del proyecto</dd>
                </dl>

        <h4>Práctica 2</h4>
        <p>
            El grupo deberá desarrollar la aplicación web en HTML incluyendo también la arquitectura en la parte del servidor (PHP) 
            y un prototipo funcional de la aplicación.
        </p>

        <h4>Práctica 3</h4>
        <p>
            En esta etapa el grupo deberá desarrollar la apariencia de la aplicación con uso de hojas de estilo CSS. Además 
            deberá haber incrementado las funcionalidades del proyecto.
        </p>

        <h4>Entrega final</h4>
        <p>
            Para el 5 de mayo el grupo deberá hacer una entrega de la aplicación completa y funcional
        </p>
    </section>

    <section>
        <h3>Diagrama de Gantt</h3>
        <p>El siguiente Diagrama de Gantt presenta los tiempos de las siguientes etapas de la planificación del proyecto</p>
        <img src="gantt1.png" title="Diagrama de Gantt del proyecto Escoli" alt="Diagrama de Gantt del proyecto Escoli">
        <img src="gantt2.png" title="Diagrama de Gantt del proyecto Escoli" alt="Diagrama de Gantt del proyecto Escoli">
    </section>
</body>
</html>