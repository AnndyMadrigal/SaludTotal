<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/ProductoController.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
    ShowCSS();
  ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php ShowMenu(); ?>

            <div class="layout-page">

                <?php ShowNav(); ?>

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="card mb-4 mt-4">
                            <h4 class="card-header">Agregar Producto</h4>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="card-body">

                                        <?php
                                            if(isset($_POST["Mensaje"]))
                                            {
                                                echo '<div class="alert alert-primary centrado">' . $_POST["Mensaje"] . '</div>';
                                            }
                                        ?>

                                        <form id="formAgregarProducto" class="mb-3" action="" method="POST" enctype="multipart/form-data">

                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="Nombre" name="Nombre" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Descripción</label>
                                                <textarea class="form-control" id="Descripcion" name="Descripcion"
                                                    rows="4"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Precio</label>
                                                <input type="text" class="form-control" id="Precio" name="Precio" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Cantidad</label>
                                                <input type="text" class="form-control" id="Cantidad" name="Cantidad" />
                                            </div>

                                            <div class="mb-3 form-password-toggle">
                                                <label>Imagen</label>
                                                <input type="file" class="form-control" id="ImagenProducto"
                                                    name="ImagenProducto" />
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary d-grid w-25" id="btnAgregarProducto"
                                                    name="btnAgregarProducto" type="submit">Procesar</button>
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

    <?php
      ShowJS();
    ?>
    <script src="../js/AgregarProducto.js"></script>

</body>

</html>