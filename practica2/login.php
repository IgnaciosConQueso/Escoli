<?php
session_start();
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <title>Login</title>
</head>

<body>
    <div id = contenedor>
        <?php include 'cabecera.php' ?>

        <?php include 'sidebarIzq.php' ?>
        <main>
            <article>
                <h1>Inicio de sesión</h1>
                <form action="procesaLogin.php" method='post'>
                    <p>Nombre de usuario</p>
                    <input type="text" name="username" id="username">
                    <p>Contraseña</p>
                    <input type="password" name="password" id="password">
                    <p></p>
                    <input type="submit" value="Iniciar sesión">
                </form>
            </article>

        </main>

        <?php include 'sidebarDer.php' ?>

        <?php include 'pie.php' ?>

    </div> <!-- Fin del contenedor -->
</body>

</html>