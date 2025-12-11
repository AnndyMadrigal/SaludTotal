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
                  <img src="../img/favicon.ico" height="50" width="50"/>
                  <span class="app-brand-text demo text-body fw-bolder">Iniciar Sesión</span>
                </a>
              </div>

              <?php
                if(isset($_POST["Mensaje"]))
                {
                    echo '<div class="alert alert-primary centrado">' . $_POST["Mensaje"] . '</div>';
                }
              ?>

              <form id="formInicioSesion" class="mb-3" action="" method="POST">
                
                <div class="mb-3">
                  <label for="NombreUsuario" class="form-label">Usuario</label>
                  <input type="text" class="form-control" id="NombreUsuario" name="NombreUsuario" placeholder="Ingrese su usuario" autofocus required />
                </div>

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="Contrasenna">Contraseña</label>
                  <div class="input-group input-group-merge">
                    <input type="password" class="form-control" id="Contrasenna" name="Contrasenna" placeholder="············" required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" id="btnIniciarSesion" name="btnIniciarSesion" type="submit">Procesar</button>
                </div>

              </form>

              <p class="text-center">
                <span>Nuevo en nuestro sistema?</span>
                <a href="Registro.php">
                  <span>Crear una cuenta</span>
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
    <script src="../js/InicioSesion.js"></script>
  
  </body>
</html>