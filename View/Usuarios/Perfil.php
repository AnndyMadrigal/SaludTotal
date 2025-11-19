<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/UsuarioController.php';

  $resultado = ConsultarUsuario();
?>

<!DOCTYPE html>
<html lang="en">

<?php
    ShowCSS();
  ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php ShowMenu(); ?>

            <div class="layout-page">

                <?php ShowNav(); ?>

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Información del Perfil</h4>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="card-body">

                                        <?php
                                            if(isset($_POST["Mensaje"]))
                                            {
                                                echo '<div class="alert alert-primary centrado">' . $_POST["Mensaje"] . '</div>';
                                            }
                                        ?>

                                        <form id="formPerfil" class="mb-3" action="" method="POST">

                                            <div class="mb-3">
                                                <label class="form-label">Identificación</label>
                                                <input type="text" class="form-control" id="Identificacion"
                                                    name="Identificacion" value="<?php echo $resultado["Identificacion"]?>" onkeyup="ConsultarNombre();" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="Nombre" name="Nombre"
                                                    readOnly="true" value="<?php echo $resultado["Nombre"]?>" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="CorreoElectronico"
                                                    name="CorreoElectronico" value="<?php echo $resultado["CorreoElectronico"]?>" />
                                            </div>

                                            <div class="mb-3 form-password-toggle">
                                                <label>Perfil</label>
                                                <input type="text" class="form-control" id="NombrePerfil"
                                                    name="NombrePerfil" readOnly="true" value="<?php echo $resultado["NombrePerfil"]?>" />
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary d-grid w-25" id="btnActualizarPerfil"
                                                    name="btnActualizarPerfil" type="submit">Procesar</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php ShowFooter(); ?>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <?php
      ShowJS();
    ?>
    <script src="../js/Perfil.js"></script>

</body>

</html>