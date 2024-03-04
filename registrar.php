<?php
include 'db.php'; // Incluir los datos de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $conexion->real_escape_string($_POST['nombre_usuario']);
    $licencia = $conexion->real_escape_string($_POST['licencia']);
    $correo_electronico = $conexion->real_escape_string($_POST['correo_electronico']);
    $password = $conexion->real_escape_string($_POST['password']);
    $confirm_password = $conexion->real_escape_string($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre_usuario, licencia, correo_electronico, password) VALUES ('$nombre_usuario', '$licencia', '$correo_electronico', '$password_hash')";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro exitoso.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    $conexion->close();
}
?>
