<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/SucursalController.php';

  $idSucursal = $_GET["id"] ?? 0;
  $resultado = ConsultarSucursal($idSucursal);
  
  if ($resultado == null) {
      //manejar error de ID no encontrado
      header("Location: Sucursales.php");
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
                            <h4 class="card-header">Actualizar Sucursal: <?= $resultado['nombre'] ?></h4>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <form id="formActualizarSucursal" class="mb-3"
                                            action="../../Controller/SucursalController.php" method="POST">

                                            <input type="hidden" name="IDSucursal"
                                                value="<?= $resultado['id_sucursal'] ?>" />

                                            <div class="mb-3">
                                                <label class="form-label" for="Nombre">Nombre</label>
                                                <input type="text" class="form-control" id="Nombre" name="Nombre"
                                                    value="<?= htmlspecialchars($resultado['nombre']) ?>" required />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="IDDireccion">ID Dirección</label>
                                                <input type="number" class="form-control" id="IDDireccion" name="IDDireccion"
                                                    value="<?= $resultado['id_direccion'] ?>" required />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="Telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="Telefono" name="Telefono"
                                                    value="<?= htmlspecialchars($resultado['telefono']) ?>" required />
                                            </div>
                                            
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary d-grid w-25"
                                                    id="btnActualizarSucursal" name="btnActualizarSucursal"
                                                    type="submit">Procesar</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ShowFooter(); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <?php ShowJS(); ?>
    <script src="../js/ActualizarSucursal.js"></script>
</body>
</html>