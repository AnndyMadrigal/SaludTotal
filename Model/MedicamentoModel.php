<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

function ConsultarMedicamentosModel()
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_MEDICAMENTO_TB_LISTAR_SP");
}

function ConsultarMedicamentoPorIDModel($id)
{
    $data = EjecutarRefCursorSP(PKG_NAME . "FIDE_MEDICAMENTO_OBTENER_SP", ['P_ID_MEDICAMENTO' => $id]);
    return empty($data) ? null : $data[0];
}

function AgregarMedicamentoModel($nombre, $principio, $presentacion, $precio)
{
    $params = [
        'P_NOMBRE_COMERCIAL' => $nombre,
        'P_PRINCIPIO_ACTIVO' => $principio,
        'P_PRESENTACION'     => $presentacion,
        'P_PRECIO_VENTA'     => $precio,
        'P_ID_ESTADO'        => 1 //Activo por defecto
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_MEDICAMENTO_TB_INSERTAR_SP", $params);
}

function ActualizarMedicamentoModel($id, $nombre, $principio, $presentacion, $precio)
{
    $params = [
        'P_ID_MEDICAMENTO'   => $id,
        'P_NOMBRE_COMERCIAL' => $nombre,
        'P_PRINCIPIO_ACTIVO' => $principio,
        'P_PRESENTACION'     => $presentacion,
        'P_PRECIO_VENTA'     => $precio
        
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_MEDICAMENTO_TB_ACTUALIZAR_SP", $params);
}

// NUEVO: Función para cambiar estado
function CambiarEstadoMedicamentoModel($id, $nuevoEstado)
{
    $params = [
        'P_ID_MEDICAMENTO' => $id,
        'P_ID_ESTADO'      => $nuevoEstado
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_MEDICAMENTO_TB_ELIMINAR_SP", $params);
}
