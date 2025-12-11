<?php
include_once '../LayoutInterno.php';
include_once '../../Controller/FacturacionController.php';

$id = $_GET['id'] ?? 0;
$datos = VerDetalleFactura($id);
$enc = $datos['header'];
$det = $datos['detalles'];

if (!$enc) {
    echo "Factura no encontrada";
    exit;
}
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

                        <div class="mb-3">
                            <a href="MisFacturas.php" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Volver al Historial
                            </a>
                        </div>

                        <div class="card invoice-preview-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                                    <div class="mb-xl-0 mb-4">
                                        <h4>Factura #<?= $enc['id_factura'] ?></h4>
                                        <p class="mb-1">Fecha: <?= $enc['fecha_formato'] ?></p>
                                        <p class="mb-1">Sucursal: <?= $enc['sucursal'] ?></p>
                                    </div>
                                    <div>
                                        <h4>Paciente:</h4>
                                        <p class="mb-1"><?= $enc['nombre_paciente'] ?></p>
                                    </div>
                                </div>
                                <hr class="my-4" />

                                <div class="table-responsive">
                                    <table class="table border-top m-0">
                                        <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Precio</th>
                                                <th>Cant</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($det as $d): ?>
                                                <tr>
                                                    <td><?= $d['concepto'] ?></td>
                                                    <td><?= number_format($d['precio_unitario'], 2) ?></td>
                                                    <td><?= $d['cantidad'] ?></td>
                                                    <td><?= number_format($d['subtotal'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                                <td><?= number_format($enc['subtotal'], 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>IVA:</strong></td>
                                                <td><?= number_format($enc['iva'], 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                                                <td><strong><?= number_format($enc['monto_total'], 2) ?></strong></td>
                                            </tr>
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
</body>

</html>