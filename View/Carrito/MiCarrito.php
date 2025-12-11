<?php
include_once '../LayoutInterno.php';
include_once '../../Controller/CarritoController.php';

if(isset($_SESSION['Mensaje'])) {
    echo '<div class="alert alert-success">' . $_SESSION['Mensaje'] . '</div>';
    unset($_SESSION['Mensaje']); //limpiar mensaje
}
if(isset($_SESSION['Error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['Error'] . '</div>';
    unset($_SESSION['Error']); //limpiar error
}

$itemsCarrito = ObtenerCarrito();
$citasDisponibles = ObtenerCitasCombo();
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
                            <h5 class="card-header">Facturación de Cita (Carrito)</h5>
                            <div class="card-body">

                                <div class="table-responsive text-nowrap mb-4">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Precio</th>
                                                <th>Cant</th>
                                                <th>Subtotal</th>
                                                <th>IVA (13%)</th>
                                                <th>Total</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $granTotal = 0;
                                            if ($itemsCarrito):
                                                foreach ($itemsCarrito as $item):
                                                    $granTotal += $item['total_linea'];
                                            ?>
                                                    <tr>
                                                        <td>  <?= htmlspecialchars($item['nombre_item']) ?></td>
                                                        <td>₡ <?= number_format($item['precio_unitario'], 2) ?></td>
                                                        <td>  <?= $item['cantidad'] ?></td>
                                                        <td>₡ <?= number_format($item['subtotal'], 2) ?></td>
                                                        <td>₡ <?= number_format($item['impuesto'], 2) ?></td>
                                                        <td>₡ <?= number_format($item['total_linea'], 2) ?></td>
                                                        <td>
                                                            <form method="POST" action="../../Controller/CarritoController.php" style="margin:0;">
                                                                <input type="hidden" name="id_carrito" value="<?= $item['id_carrito'] ?>">
                                                                <button type="submit" name="btnEliminarItem" class="btn btn-danger btn-sm" title="Eliminar del Carrito">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">El carrito está vacío</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <?php if ($granTotal > 0): ?>
                                            <tfoot>
                                                <tr class="table-secondary">
                                                    <td colspan="5" class="text-end"><strong>MONTO A CANCELAR:</strong></td>
                                                    <td colspan="2"><strong>₡ <?= number_format($granTotal, 2) ?></strong></td>
                                                </tr>
                                            </tfoot>
                                        <?php endif; ?>
                                    </table>
                                </div>

                                <hr>

                                <form action="../../Controller/CarritoController.php" method="POST">

                                    <div class="mb-4">
                                        <label for="cboCita" class="form-label">Seleccione la Cita a Facturar:</label>
                                        <select class="form-select" name="cboCita" id="cboCita" required>
                                            <option value="">-- Seleccione Paciente/Cita --</option>
                                            <?php
                                            if ($citasDisponibles && is_array($citasDisponibles) && count($citasDisponibles) > 0):
                                                foreach ($citasDisponibles as $cita):
                                            ?>
                                                    <option value="<?= $cita['id_cita'] ?>">
                                                        <?= htmlspecialchars($cita['info_cita']) ?>
                                                    </option>
                                                <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <option value="" disabled>No hay citas pendientes disponibles.</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <?php if ($granTotal > 0): ?>
                                        <button type="submit" name="btnRealizarPago" class="btn btn-primary btn-lg w-100">
                                            <i class="fa fa-money-bill"></i> Realizar Pago
                                        </button>
                                    <?php endif; ?>

                                </form>

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