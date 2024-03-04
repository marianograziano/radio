<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

echo "<h1>Bienvenido, " . $_SESSION['nombre_usuario'] . "!</h1>";
echo "<h1>Rol: " . $_SESSION['rol'] . "</h1>";

if ($_SESSION['rol'] == 'admin') {
    // Contenido para admin
    echo "<p>Contenido exclusivo para administradores.</p>";
} else {
    // Contenido para radioaficionados
    echo "<p>Contenido exclusivo para radioaficionados.</p>";
}
?>
