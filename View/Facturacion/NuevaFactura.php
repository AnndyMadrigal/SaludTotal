<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  // Incluimos controladores para cargar las listas
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PacienteController.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PersonalController.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/MedicamentoController.php';
  // Necesitamos un controlador nuevo para Servicios
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/FacturaController.php'; 

  $pacientes = ConsultarPacientes();
  $medicos = ConsultarPersonal(); // Filtrar solo médicos idealmente
  $medicamentos = ConsultarMedicamentos();
  $servicios = ConsultarServicios(); // Debes crear esta función en FacturaController
?>

<!DOCTYPE html>
<html lang="en">
<?php ShowCSS(); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <form id="formFactura" action="../../Controller/FacturaController.php" method="POST">

                            <div class="card mb-4">
                                <h5 class="card-header">Nueva Factura</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Paciente</label>
                                            <select class="form-select" name="IDPaciente" required>
                                                <option value="">Seleccione...</option>
                                                <?php foreach($pacientes as $p) echo "<option value='".$p['id_paciente']."'>".$p['nombre']." ".$p['apellido_paterno']."</option>"; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Médico Tratante</label>
                                            <select class="form-select" name="IDMedico" required>
                                                <option value="">Seleccione...</option>
                                                <?php foreach($medicos as $m) echo "<option value='".$m['id_personal']."'>".$m['nombre']." ".$m['apellido_paterno']."</option>"; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Detalle de Factura</h5>
                                    <button type="button" class="btn btn-primary btn-sm" id="btnAgregarLinea">
                                        <i class="fa fa-plus"></i> Agregar Línea
                                    </button>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped" id="tablaDetalles">
                                        <thead>
                                            <tr>
                                                <th width="15%">Tipo</th>
                                                <th width="35%">Descripción</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="15%">Precio Unit.</th>
                                                <th width="15%">Subtotal</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyDetalles">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                                <td><input type="text" class="form-control-plaintext text-end"
                                                        id="txtSubtotalGeneral" name="SubtotalGeneral" value="0.00"
                                                        readonly></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>IVA (13%):</strong></td>
                                                <td><input type="text" class="form-control-plaintext text-end"
                                                        id="txtIVA" name="IVA" value="0.00" readonly></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                                <td><input type="text" class="form-control-plaintext text-end fw-bold"
                                                        id="txtTotal" name="Total" value="0.00" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="btnGuardarFactura" class="btn btn-success btn-lg">Generar
                                    Factura</button>
                            </div>

                        </form>

                    </div> <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div> <?php ShowJS(); ?>

    <div id="listaServicios" style="display:none;">
        <?php foreach($servicios as $s) echo "<option value='".$s['id_servicio']."'>".$s['nombre']."</option>"; ?>
    </div>
    <div id="listaMedicamentos" style="display:none;">
        <?php foreach($medicamentos as $m) echo "<option value='".$m['id_medicamento']."'>".$m['nombre_comercial']." (".$m['presentacion'].")</option>"; ?>
    </div>

    <script src="../js/Facturacion.js"></script>

</body>

</html>