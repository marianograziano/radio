<?php
include('includes/config.php');
include('includes/db.php');
include('includes/functions.php');
secure();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han recibido todos los campos necesarios
    if (isset($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['password'], $_POST['active'], $_POST['rol'], $_POST['licencia'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $hashed_password = sha1($_POST['password']);
        $rol = $_POST['rol'];
        $licencia = $_POST['licencia'];
        $activo = $_POST['active'];
        if ($connect) {
            // $query = 'INSERT INTO usuarios (nombre, apellido, correo, password, activo, rol, licencia) VALUES (?, ?, ?, ?, ?, ?, ?)';
            $query = 'UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, password = ?, activo = ?, rol = ?, licencia = ? WHERE id = ?';
            if ($stmt = $connect->prepare($query)) {
                $stmt->bind_param('ssssissi', $nombre, $apellido, $correo, $hashed_password, $activo, $rol, $licencia, $_GET['id']);
                if ($stmt->execute()) {
                    set_message('Usuario Modificado');
                    header('Location: users.php');
                    exit();
                } else {
                    set_message('Error al ejecutar la consulta: ' . $stmt->error);
                }
                $stmt->close();
            } else {
                echo 'Error al preparar la consulta: ' . $connect->error;
            }
            // if (isset($_POST['password'])) {
            //     if ($stm = $connect->prepare('UPDATE usuarios SET password = ? WHERE id = ?')) {
            //         $hashed_password = sha1($_POST['password']);
            //         $stm->bind_param('si', $hashed_password, $_GET['id']);
            //         if ($stm->execute()) {
            //             set_message('Usuario Modificado');
            //             header('Location: users.php');
            //             exit();
            //         } else {
            //             set_message('Error al ejecutar la consulta: ' . $stm->error);
            //         }
            //         $stm->close();
                

        } else {
            echo 'Error de conexión a la base de datos';
        }
    } else {
        echo 'Por favor, completa todos los campos del formulario';
    }
}
include('includes/header.php');
var_dump($_GET);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = 'SELECT * FROM usuarios WHERE id = ?';
    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {

            ?>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit </h1>
                        <form method="post">
                            <div class="form-outline mb-4">
                                <input type="text" id="nombre" name="nombre" class="form-control active"
                                    value="<?php echo $user['nombre']; ?>" />

                                <label class="form-label" for="nombre">Nombre</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" id="apellido" name="apellido" class="form-control active"
                                    value="<?php echo $user['apellido']; ?>" />

                                <label class="form-label" for="apellido">Apellido</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="email" id="correo" name="correo" class="form-control active"
                                    value="<?php echo $user['correo']; ?>" />

                                <label class="form-label" for="correo">Correo</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="form-outline mb-4">
                                <select name="active" class="form-select" id="active">
                                    <option <?php echo ($user['activo']) ? "selected" : ""; ?> value="1">Activo</option>
                                    <option <?php echo ($user['activo']) ? "" : "selected"; ?> value="0">Inactivo</option>
                                </select>
                            </div>
                            <div class="form-outline mb-4">
                                <select name="rol" class="form-select" id="rol">
                                    <option <?php echo ($user['rol']) ? "selected" : ""; ?> value="1">admin</option>
                                    <option <?php echo ($user['rol']) ? "" : "selected"; ?> value="0">radioaficionado</option>
                                </select>

                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" id="licencia" name="licencia" class="form-control active"
                                    value="<?php echo $user['licencia']; ?>" />

                                <label class="form-label" for="licencia">Licencia</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Agregar Usuario</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            $stmt->close();
        } else {
            echo 'Error al preparar la consulta: ' . $connect->error;
        }
    } else {
        echo 'No se ha recibido el id del usuario';
    }
}

include('includes/footer.php');
?>