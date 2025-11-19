<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutExterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/InicioController.php';
?>

<!DOCTYPE html>
<html lang="en">
  
  <?php
      ShowCSS()
  ?>

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <img src="../img/logo.png" />
                  <span class="app-brand-text demo text-body fw-bolder">Crear Cuenta</span>
                </a>
              </div>

              <?php
                if(isset($_POST["Mensaje"]))
                {
                    echo '<div class="alert alert-primary centrado">' . $_POST["Mensaje"] . '</div>';
                }
              ?>

              <form id="formRegistro" class="mb-3" action="" method="POST">
                <div class="mb-3">
                  <label for="username" class="form-label">Identificación</label>
                  <input type="text" class="form-control" id="Identificacion" name="Identificacion"
                  onkeyup="ConsultarNombre();" />
                </div>

                 <div class="mb-3">
                  <label for="username" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="Nombre" name="Nombre" readOnly="true" />
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Correo Electrónico</label>
                  <input type="email" class="form-control" id="CorreoElectronico" name="CorreoElectronico" />
                </div>
                
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Contraseña</label>
                  <input type="password" class="form-control" id="Contrasenna" name="Contrasenna" />
                </div>

                <button class="btn btn-primary d-grid w-100" id="btnCrearCuenta" name="btnCrearCuenta" type="submit">Procesar</button>
              </form>

              <p class="text-center">
                <span>Ya tienes una cuenta?</span>
                <a href="IniciarSesion.php">
                  <span>Iniciar Sesión</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      ShowJS()
    ?>
    <script src="../js/Registro.js"></script>

  </body>
</html>