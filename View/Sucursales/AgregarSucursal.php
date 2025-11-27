<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
?>
<!DOCTYPE html>
<html lang="en"> <?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Agregar Sucursal</h4>
                            <div class="card-body">

                                <form action="../../Controller/SucursalController.php" method="POST">
                                    <h6 class="mb-3 text-muted">Información General</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3"><label>Nombre Sucursal</label><input type="text"
                                                class="form-control" name="Nombre" required></div>
                                        <div class="col-md-6 mb-3"><label>Teléfono</label><input type="text"
                                                class="form-control" name="Telefono" required></div>
                                    </div>

                                    <hr class="my-4">

                                    <h6 class="mb-3 text-muted">Ubicación</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Provincia</label>
                                            <select class="form-select" id="cboProvincia" required></select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Cantón</label>
                                            <select class="form-select" id="cboCanton" disabled required></select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Distrito</label>
                                            <select class="form-select" name="cboDistrito" id="cboDistrito" disabled
                                                required></select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Detalles Exactos</label>
                                        <textarea class="form-control" name="DetallesDireccion" rows="2"
                                            placeholder="Ej: 200m Sur de la iglesia..." required></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Sucursales.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnAgregarSucursal"
                                            type="submit">Guardar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div> <?php ShowJS(); ?>
    <script src="../js/agregarDireccion.js"></script>
</body>

</html>