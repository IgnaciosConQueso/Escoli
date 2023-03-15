<?php
session_start();
$username = htmlspecialchars(trim(strip_tags($_REQUEST["username"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));
if ($username == "aluque" && $password == "12345") {
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = "Usuario";
} else if ($username == "admin" && $password == "adminpass") {
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = "Administrador";
    $_SESSION["esAdmin"] = true;
}
?>

<!DOCTYPE html>

<html lang="es">

<head>
    <link rel="stylesheet" href="estilo.css">
    <meta content=" text/html; charset=utf-8">
    <title>procesaLogin</title>
</head>

<div id="contenedor">
    <?php
    include("cabecera.php");
    include("sidebarIzq.php");
    ?>
    <main id="contenido">
        <?php
        if (!isset($_SESSION["login"])) { //Usuario incorrecto
            echo "<h1>ERROR</h1>";
            echo "<p>El usuario o contraseña no son válidos.</p>";
        } else { //Usuario registrado
            echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
            echo "<p>Usa el menú de la izquierda para navegar.</p>";
        }
        ?>
    </main>
    <?php
    include("sidebarDer.php");
    include("pie.php");
    ?>
</div> <!-- Fin del contenedor -->
</body>

</html>