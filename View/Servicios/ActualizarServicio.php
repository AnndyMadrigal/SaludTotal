<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/ServiciosController.php';

$id = $_GET["id"];
$datos = ConsultarServicio($id);

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
                            <h4 class="card-header">Editar Servicio</h4>
                            <div class="card-body">

                                <form action="../../Controller/ServiciosController.php" method="POST">
                                    <input type="hidden" name="IDServicio" value="<?= $datos['id_servicio'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre del Servicio</label>
                                        <input type="text" class="form-control" name="Nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Descripción</label>
                                        <input type="text" class="form-control" name="Descripcion" value="<?= htmlspecialchars($datos['descripcion']) ?>" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Precio</label>
                                        <input type="number" step="0.01" class="form-control" name="Precio" value="<?= number_format((float)$datos['precio'], 2, '.', '') ?>" required />
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Servicios.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnActualizarServicio" type="submit">Actualizar</button>
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