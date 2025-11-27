<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
?>
<!DOCTYPE html>
<html lang="en"> <?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Agregar Paciente</h4>
                            <div class="card-body">

                                <form action="../../Controller/PacienteController.php" method="POST">
                                    <h6 class="mb-3 text-muted">Datos Personales</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3"><label>Nombre</label><input type="text"
                                                class="form-control" name="Nombre" required></div>
                                        <div class="col-md-4 mb-3"><label>Apellido Paterno</label><input type="text"
                                                class="form-control" name="ApellidoP" required></div>
                                        <div class="col-md-4 mb-3"><label>Apellido Materno</label><input type="text"
                                                class="form-control" name="ApellidoM" required></div>
                                    </div>
                                    <div class="mb-3"><label>Fecha Nacimiento</label><input type="date"
                                            class="form-control" name="FechaNac" required></div>

                                    <hr class="my-4">

                                    <h6 class="mb-3 text-muted">Dirección de Residencia</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Provincia</label>
                                            <select class="form-select" id="cboProvincia" required>
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Cantón</label>
                                            <select class="form-select" id="cboCanton" disabled required>
                                                <option value="">Seleccione provincia primero</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Distrito</label>
                                            <select class="form-select" name="cboDistrito" id="cboDistrito" disabled
                                                required>
                                                <option value="">Seleccione cantón primero</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Detalles Exactos (Señas)</label>
                                        <textarea class="form-control" name="DetallesDireccion" rows="2"
                                            placeholder="Ej: Frente al parque, casa azul..." required></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Pacientes.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnAgregarPaciente"
                                            type="submit">Guardar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div> <?php ShowJS(); ?>

    <script src="../js/agregarDireccion.js">    </script>

</body>

</html>