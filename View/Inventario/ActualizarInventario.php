<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/InventarioController.php';

$id = $_GET["id"];
$datos = ConsultarInventarioPorID($id);

if (!$datos) {
    header("Location: Inventario.php");
    exit;
}
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
                            <h4 class="card-header">Actualizar Stock</h4>
                            <div class="card-body">

                                <form action="../../Controller/InventarioController.php" method="POST">
                                    <input type="hidden" name="IDInventario" value="<?= $datos['id_inventario'] ?>">
                                    <input type="hidden" name="IDSucursal" value="<?= $datos['id_sucursal'] ?>">
                                    <input type="hidden" name="IDMedicamento" value="<?= $datos['id_medicamento'] ?>">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sucursal</label>
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($datos['nombre_sucursal']) ?>" readonly disabled />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Medicamento</label>
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($datos['detalle_medicamento']) ?>" readonly disabled />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="Stock" min="0" value="<?= $datos['stock'] ?>" required />
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fecha de Vencimiento</label>
                                            <input type="date" class="form-control" name="FechaVenc"
                                                value="<?= date('Y-m-d', strtotime($datos['fecha_vencimiento'])) ?>" required />
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Estado</label>
                                            <select class="form-select" name="Estado" required>
                                                <option value="1" <?= $datos['id_estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                                                <option value="2" <?= $datos['id_estado'] == 2 ? 'selected' : '' ?>>Inactivo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Inventario.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnActualizarInventario" type="submit">Actualizar</button>
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