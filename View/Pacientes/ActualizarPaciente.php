<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PacienteController.php';

  //usamos la nueva función FULL que trae IDs de direcciones
  $p = ConsultarPacienteFull($_GET["id"]);
  
  if(!$p) header("Location: Pacientes.php");
?>
<!DOCTYPE html>
<html lang="en"> <?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Editar Paciente</h4>
                            <div class="card-body">

                                <form action="../../Controller/PacienteController.php" method="POST">
                                    <input type="hidden" name="IDPaciente" value="<?= $p['id_paciente'] ?>">
                                    <input type="hidden" name="IDDireccion" value="<?= $p['id_direccion'] ?>">

                                    <input type="hidden" id="valProvincia" value="<?= $p['id_provincia'] ?>">
                                    <input type="hidden" id="valCanton" value="<?= $p['id_canton'] ?>">
                                    <input type="hidden" id="valDistrito" value="<?= $p['id_distrito'] ?>">

                                    <h6 class="mb-3 text-muted">Datos Personales</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3"><label>Nombre</label><input type="text"
                                                class="form-control" name="Nombre" value="<?= $p['nombre'] ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3"><label>Apellido Paterno</label><input type="text"
                                                class="form-control" name="ApellidoP"
                                                value="<?= $p['apellido_paterno'] ?>" required></div>
                                        <div class="col-md-4 mb-3"><label>Apellido Materno</label><input type="text"
                                                class="form-control" name="ApellidoM"
                                                value="<?= $p['apellido_materno'] ?>" required></div>
                                    </div>

                                    <div class="mb-3"><label>Fecha Nacimiento</label>
                                        <input type="date" class="form-control" name="FechaNac"
                                            value="<?= date('Y-m-d', strtotime($p['fecha_nacimiento'])) ?>" required>
                                    </div>

                                    <hr class="my-4">

                                    <h6 class="mb-3 text-muted">Dirección de Residencia</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Provincia</label>
                                            <select class="form-select" id="cboProvincia" required></select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Cantón</label>
                                            <select class="form-select" id="cboCanton" required></select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Distrito</label>
                                            <select class="form-select" name="cboDistrito" id="cboDistrito"
                                                required></select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Detalles</label>
                                        <textarea class="form-control" name="DetallesDireccion" rows="2"
                                            required><?= $p['detalles'] ?></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Pacientes.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnActualizarPaciente"
                                            type="submit">Actualizar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div> <?php ShowJS(); ?>

    <script src="../js/actualizarDireccion.js"></script>

</body>

</html>