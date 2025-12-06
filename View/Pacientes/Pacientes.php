<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PacienteController.php';
  $datos = ConsultarPacientes();
?>
<!DOCTYPE html>
<html lang="en"> <?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-header">Gestión de Pacientes</h4>
                                <a class="btn btn-primary me-3" href="AgregarPaciente.php">Agregar</a>
                            </div>
                            <div class="card-body">
                                <table id="tPacientes" class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Fecha Nacimiento</th>
                                            <th>Dirección</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datos as $fila): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($fila['nombre'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']) ?>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($fila['fecha_nacimiento'])) ?></td>

                                            <td><?= htmlspecialchars($fila['direccion_completa']) ?></td>

                                            <td>
                                                <?php if($fila['id_estado'] == 1): ?>
                                                <span class="badge bg-label-success">Activo</span>
                                                <?php else: ?>
                                                <span class="badge bg-label-danger">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="ActualizarPaciente.php?id=<?= $fila['id_paciente'] ?>"><i
                                                            class="fa fa-edit fs-4"></i></a>
                                                    <form method="POST"
                                                        action="../../Controller/PacienteController.php">
                                                        <input type="hidden" name="IDPaciente"
                                                            value="<?= $fila['id_paciente'] ?>">
                                                        <input type="hidden" name="EstadoActual"
                                                            value="<?= $fila['id_estado'] ?>">
                                                        <button type="submit" name="btnCambiarEstado"
                                                            class="btn btn-link p-0"><i
                                                                class="fa fa-refresh fs-4"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php ShowJS(); ?>
    <script src="../js/datatables/VerPacientes.js"></script>
</body>

</html>