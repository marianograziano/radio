<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_electronico = $conexion->real_escape_string($_POST['correo_electronico']);
    $password = $conexion->real_escape_string($_POST['password']);

    $sql = "SELECT id, nombre_usuario, password, rol FROM usuarios WHERE correo_electronico = '$correo_electronico'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];
            $_SESSION['rol'] = $fila['rol'];

            header("Location: index.php");
            exit;
        } else {
            $error_login = "Contraseña incorrecta.";
        }
    } else {
        $error_login = "No existe el usuario.";
    }
    // Si llegamos aquí, el inicio de sesión falló
    echo $error_login;
}
?>
