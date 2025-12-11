<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

function AgregarCarritoModel($usuario, $idServicio, $idMedicamento, $cantidad)
{
    $params = [
        'P_USUARIO'        => $usuario,
        'P_ID_SERVICIO'    => $idServicio,
        'P_ID_MEDICAMENTO' => $idMedicamento,
        'P_CANTIDAD'       => $cantidad
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_CARRITO_AGREGAR_SP", $params);
}

function ListarCarritoModel($usuario)
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_CARRITO_LISTAR_SP", ['P_USUARIO' => $usuario]);
}

function EliminarItemCarritoModel($idCarrito)
{
    return EjecutarAccionSP(PKG_NAME . "FIDE_CARRITO_ELIMINAR_ITEM_SP", ['P_ID_CARRITO' => $idCarrito]);
}

function ProcesarFacturaModel($usuario, $idPaciente, $idSucursal)
{
    $mensaje = '';
    $conn = OpenConnection();
    
    $sql = "BEGIN " . PKG_NAME . "FIDE_PROCESAR_FACTURA_SP(:p_user, :p_pac, :p_suc, :p_pago, :p_res); END;";
    $stmt = oci_parse($conn, $sql);
    
    $medioPago = 'Efectivo/Tarjeta';

    oci_bind_by_name($stmt, ":p_user", $usuario);
    oci_bind_by_name($stmt, ":p_pac", $idPaciente);
    oci_bind_by_name($stmt, ":p_suc", $idSucursal);
    oci_bind_by_name($stmt, ":p_pago", $medioPago);
    oci_bind_by_name($stmt, ":p_res", $mensaje, 500);//Salida

    $resultado = oci_execute($stmt);
    CloseConnection($conn);
    
    return $mensaje;
}

//para llenar los combos
function ObtenerPacientesCombo() {
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_PACIENTE_TB_LISTAR_SP");
}

function ObtenerSucursalesCombo() {
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_LISTAR_SP");
}

function ListarFacturasModel() {
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_FACTURA_LISTAR_SP");
}

function ObtenerFacturaHeaderModel($id) {
    $data = EjecutarRefCursorSP(PKG_NAME . "FIDE_FACTURA_OBTENER_ENCABEZADO_SP", ['P_ID_FACTURA' => $id]);
    return $data ? $data[0] : null;
}

function ObtenerFacturaDetallesModel($id) {
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_FACTURA_DETALLE_OBTENER_DETALLES_SP", ['P_ID_FACTURA' => $id]);
}

?>