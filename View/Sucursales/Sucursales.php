<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/SucursalController.php';

  $resultado = ConsultarSucursales();
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
                                <h4 class="card-header mb-0 text-center flex-grow-1">Sucursales</h4>
                                <a class="btn btn-outline-primary position-absolute end-0 me-3"
                                    href="AgregarSucursal.php">Agregar</a>
                            </div>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <table id="tSucursales" class="table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Teléfono</th>
                                                    <th>ID Dirección</th>
                                                    <th>ID Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php 
                                                    foreach ($resultado as $fila): ?>
                                                <tr>
                                                    <td><?= $fila['id_sucursal'] ?></td>
                                                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                                                    <td><?= htmlspecialchars($fila['telefono']) ?></td>
                                                    <td><?= $fila['id_direccion'] ?></td>
                                                    <td><?= $fila['id_estado'] ?></td> 
                                                    <td>
                                                        <div style="display:flex; align-items:center; gap:10px;">
                                                            <a
                                                                href="ActualizarSucursal.php?id=<?= $fila['id_sucursal'] ?>">
                                                                <i class="fa fa-edit" style="font-size:22px;"></i>
                                                            </a>

                                                            <form method="POST"
                                                                action="../../Controller/SucursalController.php"
                                                                style="margin:0; display:inline;">
                                                                <input type="hidden" name="IDSucursal"
                                                                    value="<?= $fila['id_sucursal'] ?>">
                                                                <input type="hidden" name="EstadoActual"
                                                                    value="<?= $fila['id_estado'] ?>">
                                                                <button type="submit" name="btnCambiarEstado" id="btnCambiarEstado"
                                                                    style="background:none; border:none; color:#0d6efd; cursor:pointer; padding:0;"
                                                                    title="Cambiar Estado (Activar/Desactivar)">
                                                                    <i class="fa fa-refresh"
                                                                        style="font-size:22px;"></i>
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
    <script src="../js/VerSucursales.js"></script>
</body>
</html>