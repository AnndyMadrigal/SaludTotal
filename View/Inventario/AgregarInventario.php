<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/InventarioController.php';

// Cargamos listas para los dropdowns
$sucursales = ObtenerSucursales();
$medicamentos = ObtenerMedicamentos();
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
                            <h4 class="card-header">Registrar Stock en Inventario</h4>
                            <div class="card-body">

                                <form action="../../Controller/InventarioController.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sucursal</label>
                                            <select class="form-select" name="IDSucursal" required>
                                                <option value="">Seleccione una sucursal</option>
                                                <?php foreach ($sucursales as $s): ?>
                                                    <option value="<?= $s['id_sucursal'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Medicamento</label>
                                            <select class="form-select" name="IDMedicamento" required>
                                                <option value="">Seleccione un medicamento</option>
                                                <?php foreach ($medicamentos as $m): ?>
                                                    <option value="<?= $m['id_medicamento'] ?>">
                                                        <?= htmlspecialchars($m['nombre_comercial'] . " - " . $m['presentacion']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock Disponible</label>
                                            <input type="number" class="form-control" name="Stock" min="0" required />
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fecha de Vencimiento</label>
                                            <input type="date" class="form-control" name="FechaVenc" required />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Inventario.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnAgregarInventario" type="submit">Guardar Stock</button>
                                    </div>
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