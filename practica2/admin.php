<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="estilo.css">
    <meta content="text/html; charset=utf-8">
    <title>Admin</title>
</head>

<body>
    <div id=contenedor>

        <?php include 'cabecera.php' ?>

        <?php include 'sidebarIzq.php' ?>

        <main>
            <article>
                <?php
                if (isset($_SESSION["esAdmin"])) {
                    echo "<h1>Admin Console</h1>";
                    echo "<p>Herramientas de administrador para la página web.</p>";
                } else {
                    echo "<h1>ERROR</h1>";
                    echo "<p>No tiene permiso.</p>";
                }
                ?>
            </article>
        </main>

        <?php include 'sidebarDer.php' ?>

        <?php include 'pie.php' ?>

    </div> <!-- Fin del contenedor -->

</body>

</html>