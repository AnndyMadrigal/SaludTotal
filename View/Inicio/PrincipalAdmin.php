<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/InicioController.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/ProductoController.php';

  if($_SESSION["ConsecutivoPerfil"] != "1")
  {
    header("Location: Principal.php");
    exit;
  }

  $resultado = ConsultarIndicadores();

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


                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-3 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="../img/chart-success.png"
                                                    alt="chart success" class="rounded">
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Productos Activos</span>
                                        <h3 class="card-title mb-2"><?= $resultado["Cantidad"] ?>  </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-3 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="../img/chart-success.png"
                                                    alt="chart success" class="rounded">
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Productos Inactivos</span>
                                        <h3 class="card-title mb-2"><?= $resultado["Cantidad"] ?>  </h3>
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

</body>

</html>