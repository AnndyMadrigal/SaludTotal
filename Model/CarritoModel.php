<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

//Agregar Item (Servicio o Medicamento)
function AgregarItemCarritoModel($usuario, $idServicio, $idMedicamento)
{
    $params = [
        'P_USUARIO_SISTEMA' => $usuario,
        'P_ID_SERVICIO'     => $idServicio,
        'P_ID_MEDICAMENTO'  => $idMedicamento
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_CARRITO_AGREGAR_SP", $params);
}

//Listar Carrito
function ConsultarCarritoModel($usuario)
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_CARRITO_LISTAR_SP", ['P_USUARIO_SISTEMA' => $usuario]);
}

//Eliminar Item
function EliminarItemCarritoModel($idCarrito)
{
    return EjecutarAccionSP(PKG_NAME . "FIDE_CARRITO_ELIMINAR_SP", ['P_ID_CARRITO' => $idCarrito]);
}

//Obtener Citas para el Combo
function ConsultarCitasPendientesModel()
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_CITAS_PENDIENTES_SP");
}

//Facturar (Pagar)
function RealizarPagoCarritoModel($nombreUsuario, $idCita)
{
    $spName = PKG_NAME . "FIDE_FACTURAR_CARRITO_SP";
    $nuevoId = 0; //Variable para capturar el ID

    $conn = OpenConnection();

    $stmt = oci_parse($conn, "BEGIN $spName(:p_user, :p_cita, :p_new_id); END;");
    
    oci_bind_by_name($stmt, ":p_user", $nombreUsuario);
    oci_bind_by_name($stmt, ":p_cita", $idCita);
    oci_bind_by_name($stmt, ":p_new_id", $nuevoId, 32);

    if(oci_execute($stmt)) {
        CloseConnection($conn);
        return $nuevoId;
    } else {
        CloseConnection($conn);
        return false;
    }
}
?>