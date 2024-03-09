<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Remover todas las variables de sesión
    $_SESSION = array();

    // Destruir la sesión.
    session_destroy();

    // Redirigir al usuario a index.php con un mensaje de salida
    // Utilizamos la función header para redirigir y exit para terminar la ejecución del script
    header("Location: index.php?mensaje=Usted ha salido correctamente");
    exit();
}

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db.php');

    $conexion = new mysqli($host, $user, $pass, $db);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
       /// if (password_verify($contraseña, $usuario['contraseña'])) {
        if ($password == $usuario['password']) {
            $_SESSION['usuario'] = $usuario; // Guardar datos del usuario en la sesión
        } else {
            $loginError = "Contraseña incorrecta";
            echo "pass $password";
            echo "usuario pass " . $usuario['password'];
        }
    } else {
        $loginError = "Usuario no encontrado";
    }

    $conexion->close();
}

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    // Mostrar datos del usuario
    echo "<h2>Datos del Usuario</h2>";
    echo "<ul>";
    echo "<li>Nombre: " . htmlspecialchars($usuario['nombre']) . "</li>";
    echo "<li>Apellido: " . htmlspecialchars($usuario['apellido']) . "</li>";
    echo "<li>Correo: " . htmlspecialchars($usuario['correo']) . "</li>";
    echo "<li>Rol: " . htmlspecialchars($usuario['rol']) . "</li>";
    echo "<li>Licencia: " . htmlspecialchars($usuario['licencia']) . "</li>";
    echo "</ul>";
    echo "<a href='generar_certificado.php' class='btn btn-success'>Generar Certificado</a>";
    echo "<br>";
    echo '<a href=index.php?logout=1">Salir</a>';

} else {
    // Mostrar formulario de login
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mt-5">Gestion de Eventos de Contactos</h2>
                <?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
    </div>
<?php endif; ?>
                <?php if ($loginError != '') { echo "<p class='text-danger'>$loginError</p>"; } ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="p-4">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
?>

