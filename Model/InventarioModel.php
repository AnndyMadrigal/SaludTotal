<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';
define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');

function ConsultarInventarioModel()
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_INVENTARIO_TB_LISTAR_SP");
}

function ConsultarInventarioPorIDModel($id)
{
    $data = EjecutarRefCursorSP(PKG_NAME . "FIDE_INVENTARIO_OBTENER_SP", ['P_ID_INVENTARIO' => $id]);
    return empty($data) ? null : $data[0];
}

function AgregarInventarioModel($idSuc, $idMed, $stock, $vencimiento)
{
    $params = [
        'P_ID_SUCURSAL' => $idSuc,
        'P_ID_MEDICAMENTO' => $idMed,
        'P_STOCK' => $stock,
        'P_FECHA_VENCIMIENTO' => $vencimiento, //Formato YYYY-MM-DD
        'P_ID_ESTADO' => 1
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_INVENTARIO_TB_INSERTAR_SP", $params);
}

function ActualizarInventarioModel($id, $stock, $vencimiento, $estado)
{
    $params = [
        'P_ID_INVENTARIO' => $id,
        'P_STOCK' => $stock,
        'P_FECHA_VENCIMIENTO' => $vencimiento,
        'P_ID_ESTADO' => $estado
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_INVENTARIO_TB_ACTUALIZAR_SP", $params);
}

function CambiarEstadoInventarioModel($id, $nuevoEstado)
{
    $params = ['P_ID_INVENTARIO' => $id, 'P_ID_ESTADO' => $nuevoEstado];
    return EjecutarAccionSP(PKG_NAME . "FIDE_INVENTARIO_TB_ELIMINAR_SP", $params);
}

// Listas para Dropdowns
function ListarSucursalesInv()
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_LISTAR_SP");
}

function ListarMedicamentosInv()
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_MEDICAMENTO_TB_LISTAR_SP");
}
