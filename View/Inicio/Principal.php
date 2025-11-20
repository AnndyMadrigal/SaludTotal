<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

  if(isset($_SESSION["IdRol"]) && $_SESSION["IdRol"] == "1")
{
    header("Location: PrincipalAdmin.php");
    exit;
}

$nombreUsuario = $_SESSION["NombreUsuario"] ?? "Paciente";
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
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">¡Bienvenido de nuevo, <?= htmlspecialchars($nombreUsuario) ?>! 🎉</h5>
                                                <p class="mb-4">
                                                    Bienvenido al sistema de gestión <strong>SaludTotal</strong>. 
                                                    Desde aquí podrás gestionar tus citas médicas y revisar tu facturación.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-4">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="bx bx-calendar-check mb-3 text-primary" style="font-size: 3rem;"></i>
                                        <h5 class="card-title">Mis Citas</h5>
                                        <p class="card-text">Consulta tus próximas citas médicas o agenda una nueva.</p>
                                        <a href="../Citas/MisCitas.php" class="btn btn-outline-primary">Ir a Citas</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="bx bx-receipt mb-3 text-success" style="font-size: 3rem;"></i>
                                        <h5 class="card-title">Mis Facturas</h5>
                                        <p class="card-text">Revisa tu historial de pagos y facturas pendientes.</p>
                                        <a href="../Facturacion/MisFacturas.php" class="btn btn-outline-success">Ir a Facturación</a>
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