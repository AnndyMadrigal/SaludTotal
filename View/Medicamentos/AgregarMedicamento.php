<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
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
                            <h4 class="card-header">Agregar Nuevo Medicamento</h4>
                            <div class="card-body">

                                <form action="../../Controller/MedicamentoController.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre Comercial</label>
                                        <input type="text" class="form-control" name="Nombre" placeholder="Ej: Tylenol" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Principio Activo</label>
                                        <input type="text" class="form-control" name="Principio" placeholder="Ej: Acetaminofén" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Presentación</label>
                                        <input type="text" class="form-control" name="Presentacion" placeholder="Ej: Caja 500mg" required />
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Medicamentos.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnAgregarMedicamento" type="submit">Guardar</button>
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