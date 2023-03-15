<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="estilo.css">
    <meta content="text/html; charset=utf-8">
    <title>Content</title>
</head>

<body>
    <div id=contenedor>

        <?php include 'cabecera.php' ?>

        <?php include 'sidebarIzq.php' ?>

        <main>
            <article>
                <?php
                if (isset($_SESSION['login'])) {
                    echo "<h1>HOLA</h1>";
                    echo "<p>Un poco de texto para el contenido de la página</p>";
                    echo "<p>Contenido 2</p>";
                    echo "<h4>mini título</h4>";                    
                } else {
                    echo "<h1>ERROR</h1>";
                    echo "<p>Debe iniciar sesión</p>";
                }

                ?>
            </article>
        </main>

        <?php include 'sidebarDer.php' ?>

        <?php include 'pie.php' ?>

    </div> <!-- Fin del contenedor -->

</body>

</html>