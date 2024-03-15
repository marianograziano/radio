<?php
ob_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');
include('includes/db.php');
include('includes/functions.php');


if (isset($_SESSION['id'])) {
    header('Location: starter.php');
    die();
}

if (isset($_POST['correo'])) {

    if ($stm = $connect->prepare('SELECT * FROM usuarios WHERE correo = ? AND password = ? AND activo = 1')) {
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ss', $_POST['correo'], $hashed);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['apellido'] = $user['apellido'];
            $_SESSION['licencia'] = $user['licencia'];
            $_SESSION['rol'] = $user['rol'];

            set_message("Bienvenido " . $_SESSION['nombre']);
            header('Location: starter.php');
            die();
        }
        $stm->close();
    } else {
        echo 'Could not prepare statement!';
    }




}

include('includes/headlogin.php');
?>

<div class="container">
    <div class="row justify-content-center">
  
<div class="login-box">
  <div class="login-logo">
    <b>LU1QA</b></br>
    <h5>Radio Club San Luis</h5>
    <h6>Gestor de Eventos de Contacto</h6>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Logueate para iniciar sesion</p>


      <form method="post">
        <div class="input-group mb-3">
          <input type="email" id="correo" name="correo"  class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recordarme
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Iniciar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <p class="mb-1">
        <a href="#">Olvide mi contraseña</a>
      </p>
      <p class="mb-0">
        <a href="#" class="text-center">Registrar nuevo usuario</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<?php
include('includes/footer.php');
?>