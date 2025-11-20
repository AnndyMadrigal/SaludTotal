<?php
  
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/DashboardModel.php';
  
  
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

    if(!isset($_SESSION["IdRol"]) || $_SESSION["IdRol"] != "1") {
        header("Location: Principal.php");
        exit;
    }

  // Se asume que ConsultarIndicadores() ahora devuelve los indicadores del hospital.
  // Ejemplo: ["TOTAL_USUARIOS" => 50, "TOTAL_PERSONAL" => 20, "TOTAL_SUCURSALES" => 3, "TOTAL_FACTURAS_MES" => 150]
  $kpis = ObtenerEstadisticasHospital();
  
  
  $total_usuarios = $resultado["TOTAL_USUARIOS"] ?? 0;
  $total_personal = $resultado["TOTAL_PERSONAL"] ?? 0;
  $total_sucursales = $resultado["TOTAL_SUCURSALES"] ?? 0;
  $total_facturas_mes = $resultado["TOTAL_FACTURAS_MES"] ?? 0;

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
                        <h4 class="fw-bold py-3 mb-4">
                            <span class="text-muted fw-light">SaludTotal /</span> Administración
                        </h4>

                        <div class="row">
                            
                            <div class="col-lg-3 col-md-6 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-building-house"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Sucursales</span>
                                        <h3 class="card-title mb-2"><?= $kpis["SUCURSALES"] ?></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <span class="avatar-initial rounded bg-label-success">
                                                    <i class="bx bx-user-pin"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Personal Médico</span>
                                        <h3 class="card-title mb-2"><?= $kpis["PERSONAL"] ?></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <span class="avatar-initial rounded bg-label-info">
                                                    <i class="bx bx-group"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Usuarios Activos</span>
                                        <h3 class="card-title mb-2"><?= $kpis["USUARIOS"] ?></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <span class="avatar-initial rounded bg-label-warning">
                                                    <i class="bx bx-receipt"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Facturas Generadas</span>
                                        <h3 class="card-title mb-2"><?= $kpis["FACTURAS"] ?></h3>
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
    
</body>

</html>