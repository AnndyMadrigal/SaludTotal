<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/FacturacionModel.php';

//---ACCIONES POST ---

// 1.Agregar Item
if (isset($_POST['action']) && $_POST['action'] == 'agregar') {
    $tipo = $_POST['tipo']; // 1=Servicio, 2=Medicamento
    $idItem = $_POST['id_item'];
    $cantidad = $_POST['cantidad'];

    $idServicio = ($tipo == '1') ? $idItem : null;
    $idMedicamento = ($tipo == '2') ? $idItem : null;

    AgregarCarritoModel($usuarioActual, $idServicio, $idMedicamento, $cantidad);
    echo json_encode(['status' => 'success']);
    exit;
}

//2.Eliminar Item
if (isset($_POST['action']) && $_POST['action'] == 'eliminar') {
    EliminarItemCarritoModel($_POST['id_carrito']);
    echo json_encode(['status' => 'success']);
    exit;
}

//3.Procesar Pago
if (isset($_POST['btnProcesarPago'])) {
    $idPaciente = $_POST['cboPaciente'];
    $idSucursal = $_POST['cboSucursal'];
    
    $mensaje = ProcesarFacturaModel($usuarioActual, $idPaciente, $idSucursal);
    
    echo "<script>alert('$mensaje'); window.location.href='../View/Facturacion/NuevaFactura.php';</script>";
    exit;
}

//---FUNCIONES PARA LA VISTA ---
function VerCarrito() {
    global $usuarioActual;
    return ListarCarritoModel($usuarioActual);
}

function VerPacientes() {
    return ObtenerPacientesCombo();
}

function VerSucursales() {
    return ObtenerSucursalesCombo();
}


//vista de facturas
function VerListadoFacturas() {
    return ListarFacturasModel();
}

function VerDetalleFactura($id) {
    $header = ObtenerFacturaHeaderModel($id);
    $detalles = ObtenerFacturaDetallesModel($id);
    return ['header' => $header, 'detalles' => $detalles];
}
?>