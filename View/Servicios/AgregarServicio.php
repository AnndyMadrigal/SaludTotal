<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
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
                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Agregar Nuevo Servicio</h4>
                            <div class="card-body">

                                <form action="../../Controller/ServiciosController.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre del Servicio</label>
                                        <input type="text" class="form-control" name="Nombre"
                                            placeholder="Ej: Consulta General" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Descripción</label>
                                        <input type="text" class="form-control" name="Descripcion"
                                            placeholder="Ej: Atención médica primaria" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Precio</label>
                                        <input type="number" step="0.01" class="form-control" name="Precio"
                                            placeholder="0.00" required />
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Servicios.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnAgregarServicio"
                                            type="submit">Guardar</button>
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