<?php
include_once '../LayoutInterno.php';
include_once '../../Controller/FacturacionController.php';

$facturas = VerListadoFacturas();
?>

<!DOCTYPE html>
<html lang="es">
<?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php ShowMenu(); ?>
            <div class="layout-page">
                <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="card">
                            <h5 class="card-header">Historial de Facturación</h5>
                            <div class="card-body">
                                <table id="tFacturas" class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Paciente</th>
                                            <th>Sucursal</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($facturas as $f): ?>
                                            <tr>
                                                <td><?= $f['id_factura'] ?></td>
                                                <td><?= $f['fecha_formato'] ?></td>
                                                <td><?= $f['nombre_paciente'] ?></td>
                                                <td><?= $f['sucursal'] ?></td>
                                                <td><?= number_format($f['monto_total'], 2) ?></td>
                                                <td><span class="badge bg-label-primary"><?= $f['estado'] ?></span></td>
                                                <td>
                                                    <a href="VerFactura.php?id=<?= $f['id_factura'] ?>" class="btn btn-sm btn-info">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
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
    <script src="../js/datatables/VerFacturas.js"></script>
</body>

</html>