<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/InventarioController.php';

$datos = ConsultarInventario();
?>

<!DOCTYPE html>
<html lang="en">
<?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php ShowMenu(); ?>
            <div class="layout-page">
                <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                <h4 class="card-header mb-0 text-center flex-grow-1">Gestión de Inventario</h4>
                                <a class="btn btn-outline-primary position-absolute end-0 me-3" href="AgregarInventario.php">Agregar</a>
                            </div>
                            <div class="card-body">
                                <table id="tIventario"class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th>Medicamento</th>
                                            <th>Stock</th>
                                            <th>Vencimiento</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datos as $fila): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($fila['nombre_sucursal']) ?></td>
                                                <td><?= htmlspecialchars($fila['detalle_medicamento']) ?></td>
                                                <td><?= $fila['stock'] ?></td>
                                                <td><?= date('d/m/Y', strtotime($fila['fecha_vencimiento'])) ?></td>
                                                <td>
                                                    <?php if ($fila['id_estado'] == 1): ?>
                                                        <span class="badge bg-label-success">Activo</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-label-danger">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="ActualizarInventario.php?id=<?= $fila['id_inventario'] ?>">
                                                            <i class="fa fa-edit" style="font-size:22px;"></i>
                                                        </a>

                                                        <form method="POST" action="../../Controller/InventarioController.php" style="margin:0;">
                                                            <input type="hidden" name="IDInventario" value="<?= $fila['id_inventario'] ?>">
                                                            <input type="hidden" name="EstadoActual" value="<?= $fila['id_estado'] ?>">
                                                            <button type="submit" name="btnCambiarEstado" style="background:none; border:none; color:#0d6efd; cursor:pointer;">
                                                                <i class="fa fa-refresh" style="font-size:22px;"></i>
                                                            </button>
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
    <script src="../js/datatables/VerInventario.js"></script>
</body>

</html>