<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/MedicamentoController.php';

$datos = ConsultarMedicamentos();
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
                                <h4 class="card-header mb-0 text-center flex-grow-1">Catálogo de Medicamentos</h4>
                                <a class="btn btn-outline-primary position-absolute end-0 me-3"
                                    href="AgregarMedicamento.php">Agregar</a>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive text-nowrap">

                                    <table id="tMedicamentos" class="table table-hover datatable" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Nombre Comercial</th>
                                                <th>Principio Activo</th>
                                                <th>Presentación</th>
                                                <th>Sucursal</th>
                                                <th>Precio</th>
                                                <th>Stock</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($datos as $fila): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($fila['nombre_comercial']) ?></td>
                                                <td><?= htmlspecialchars($fila['principio_activo']) ?></td>
                                                <td><?= htmlspecialchars($fila['presentacion']) ?></td>

                                                <td>
                                                    <span class="badge bg-label-info">
                                                        <?= htmlspecialchars($fila['nombre_sucursal'] ?? 'Sin Asignar') ?>
                                                    </span>
                                                </td>
                                                <td>₡ <?= number_format((float)$fila['precio_venta'], 2) ?></td>
                                                <td><?= $fila['stock'] ?? 0 ?></td>

                                                <td>
                                                    <?php if ($fila['id_estado'] == 1): ?>
                                                    <span class="badge bg-label-success">Activo</span>
                                                    <?php else: ?>
                                                    <span class="badge bg-label-danger">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <?php if ($fila['id_estado'] == 1): ?>
                                                        <form method="POST"
                                                            action="../../Controller/CarritoController.php"
                                                            style="margin:0;">
                                                            <input type="hidden" name="id_medicamento"
                                                                value="<?= $fila['id_medicamento'] ?>">
                                                            <button type="submit" name="btnAgregarMedicamento"
                                                                class="btn btn-sm btn-success"
                                                                title="Agregar al Carrito">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </form>
                                                        <?php endif; ?>

                                                        <a href="ActualizarMedicamento.php?id=<?= $fila['id_medicamento'] ?>"
                                                            class="btn btn-sm btn-outline-primary"><i
                                                                class="fa fa-edit"></i></a>

                                                        <form method="POST" action="" style="margin:0;">
                                                            <input type="hidden" name="IDMedicamento"
                                                                value="<?= $fila['id_medicamento'] ?>">
                                                            <input type="hidden" name="EstadoActual"
                                                                value="<?= $fila['id_estado'] ?>">
                                                            <button type="submit" name="btnCambiarEstado"
                                                                class="btn btn-sm btn-link p-0 text-primary"><i
                                                                    class="fa fa-refresh"></i></button>
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
                    </div>
                    <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php ShowJS(); ?>
    <script src="../js/datatables/VerMedicamentos.js"></script>
</body>

</html>