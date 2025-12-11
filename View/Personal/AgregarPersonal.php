<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PersonalController.php';
$roles = ConsultarRolesPersonal();
$sucursales = ConsultarSucursalesLista();
?>
<!DOCTYPE html>
<html lang="en"> <?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Agregar Personal</h4>
                            <div class="card-body">
                                <form action="../../Controller/PersonalController.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-4 mb-3"><label>Nombre</label><input type="text"
                                                class="form-control" name="Nombre" required></div>
                                        <div class="col-md-4 mb-3"><label>Apellido Paterno</label><input type="text"
                                                class="form-control" name="ApellidoP" required></div>
                                        <div class="col-md-4 mb-3"><label>Apellido Materno</label><input type="text"
                                                class="form-control" name="ApellidoM" required></div>
                                    </div>
                                    <div class="mb-3"><label>Fecha Contratación</label><input type="date"
                                            class="form-control" name="FechaContrato" required></div>
                                    <div class="mb-3"><label>Rol</label>
                                        <select class="form-select" name="IDRol" required>
                                            <option value="">Seleccione...</option>
                                            <?php foreach ($roles as $r) echo "<option value='" . $r['id_rol_personal'] . "'>" . $r['nombre_rol'] . "</option>"; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3"><label>Sucursal</label>
                                        <select class="form-select" name="IDSucursal" required>
                                            <option value="">Seleccione...</option>
                                            <?php foreach ($sucursales as $s) echo "<option value='" . $s['id_sucursal'] . "'>" . $s['nombre'] . "</option>"; ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary" name="btnAgregarPersonal"
                                        type="submit">Guardar</button>
                                    <a href="Personal.php" class="btn btn-outline-secondary">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </div> <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div> <?php ShowJS(); ?>
</body>

</html>