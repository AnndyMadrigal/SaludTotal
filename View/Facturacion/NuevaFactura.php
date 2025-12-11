<?php
include_once '../LayoutInterno.php';
include_once '../../Controller/FacturacionController.php';

$carrito = VerCarrito();
$pacientes = VerPacientes();
$sucursales = VerSucursales();
?>

<!DOCTYPE html>
<html lang="es">
<?php ShowCSS(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php ShowMenu(); ?>
            <div class="layout-page">
                <?php ShowNav(); ?>
                
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <h5 class="card-header">Agregar al Carrito</h5>
                                    <div class="card-body">
                                        <form id="formAgregar">
                                            <input type="hidden" name="action" value="agregar">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Tipo</label>
                                                <select class="form-select" id="cboTipo" name="tipo" required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="1">Servicio</option>
                                                    <option value="2">Medicamento</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Item</label>
                                                <select class="form-select" id="cboItem" name="id_item" disabled required>
                                                    <option value="">-- Seleccione Tipo --</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" name="cantidad" value="1" min="1" required>
                                            </div>

                                            <button type="button" class="btn btn-primary w-100" onclick="agregarAlCarrito()">
                                                <i class="fa fa-cart-plus"></i> Agregar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <h5 class="card-header">Detalle de Facturación</h5>
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Descripción</th>
                                                    <th>Cant</th>
                                                    <th>Precio</th>
                                                    <th>Subtotal</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $totalGeneral = 0;
                                                if($carrito): 
                                                    foreach($carrito as $row): 
                                                        $totalGeneral += $row['subtotal'];
                                                ?>
                                                <tr>
                                                    <td><?= $row['tipo'] ?></td>
                                                    <td><?= $row['nombre_item'] ?></td>
                                                    <td><?= $row['cantidad'] ?></td>
                                                    <td>₡ <?= number_format($row['precio_unitario'], 2) ?></td>
                                                    <td>₡ <?= number_format($row['subtotal'], 2) ?></td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm" onclick="eliminarDelCarrito(<?= $row['id_carrito'] ?>)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; endif; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                    <td><strong>₡ <?= number_format($totalGeneral, 2) ?></strong></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        
                                        <hr>
                                        
                                        <form action="../../Controller/FacturacionController.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Paciente</label>
                                                    <select class="form-select" name="cboPaciente" required>
                                                        <?php foreach($pacientes as $p): ?>
                                                            <option value="<?= $p['id_paciente'] ?>">
                                                                <?= $p['nombre'] . ' ' . $p['apellido_paterno'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Sucursal</label>
                                                    <select class="form-select" name="cboSucursal" required>
                                                        <?php foreach($sucursales as $s): ?>
                                                            <option value="<?= $s['id_sucursal'] ?>">
                                                                <?= $s['nombre'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <?php if($totalGeneral > 0): ?>
                                                <button type="submit" name="btnProcesarPago" class="btn btn-success btn-lg w-100">
                                                    <i class="fa fa-money-bill"></i> Generar Factura
                                                </button>
                                            <?php else: ?>
                                                <div class="alert alert-warning">Agregue items para facturar</div>
                                            <?php endif; ?>
                                        </form>

                                    </div>
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
    <script src="../js/carrito.js"></script>
</body>
</html>