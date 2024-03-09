<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();


if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión de usuario, redirigir a la página de login
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['usuario'];

// Configuración básica para la imagen
$ancho = 800;
$alto = 600;
$imagen = imagecreatetruecolor($ancho, $alto);

// Colores
$blanco = imagecolorallocate($imagen, 255, 255, 255);
$negro = imagecolorallocate($imagen, 0, 0, 0);

// Rellenar el fondo
imagefill($imagen, 0, 0, $blanco);

// Textos para el certificado
$textos = [
    "Nombre: " . $usuario['nombre'],
    "Apellido: " . $usuario['apellido'],
    "Correo: " . $usuario['correo'],
    "Rol: " . $usuario['rol'],
    "Licencia: " . $usuario['licencia']
];

// Añadir textos a la imagen
$y = 150; // Posición inicial en Y para el primer texto
foreach ($textos as $texto) {
    imagettftext($imagen, 20, 0, 50, $y, $negro, __DIR__ . '/Arial.ttf', $texto);
    $y += 50; // Aumentar la posición en Y para el siguiente texto
}

// Definir el tipo de contenido como imagen/png
header('Content-Type: image/png');

// Generar la imagen
imagepng($imagen);

// Liberar memoria
imagedestroy($imagen);
?>