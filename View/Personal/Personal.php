<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PersonalController.php';
  $datos = ConsultarPersonal();
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
                                <h4 class="card-header">Gestión de Personal</h4>
                                <a class="btn btn-primary me-3" href="AgregarPersonal.php">Agregar</a>
                            </div>
                            <div class="card-body">
                                <table id="tPersonal" class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Rol</th>
                                            <th>Sucursal</th>
                                            <th>Fecha Contrato</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datos as $fila): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($fila['nombre'] . ' ' . $fila['apellido_paterno']) ?>
                                            </td>

                                            <td><?= htmlspecialchars($fila['nombre_rol']) ?></td>
                                            <td><?= htmlspecialchars($fila['nombre_sucursal']) ?></td>

                                            <td><?= date('d/m/Y', strtotime($fila['fecha_contratacion'])) ?></td>
                                            <td>
                                                <?php if($fila['id_estado'] == 1): ?>
                                                <span class="badge bg-label-success">Activo</span>
                                                <?php else: ?>
                                                <span class="badge bg-label-danger">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="ActualizarPersonal.php?id=<?= $fila['id_personal'] ?>"><i
                                                            class="fa fa-edit fs-4"></i></a>
                                                    <form method="POST"
                                                        action="../../Controller/PersonalController.php">
                                                        <input type="hidden" name="IDPersonal"
                                                            value="<?= $fila['id_personal'] ?>">
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
    <script src="../js/VerPersonal.js"></script>
</body>

</html>