<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

function ConsultarServiciosModel()
{
    return EjecutarRefCursorSP(PKG_NAME . "FIDE_SERVICIO_TB_LISTAR_SP");
}

function ConsultarServicioPorIDModel($id)
{
    $data = EjecutarRefCursorSP(PKG_NAME . "FIDE_SERVICIO_TB_OBTENER_SP", ['P_ID_SERVICIO' => $id]);
    return empty($data) ? null : $data[0];
}

function AgregarServicioModel($nombre, $descripcion, $precio)
{
    $params = [
        'P_NOMBRE'      => $nombre,
        'P_DESCRIPCION' => $descripcion,
        'P_PRECIO'      => $precio,
        'P_ID_ESTADO'   => 1 //Activo por defecto
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_SERVICIO_TB_INSERTAR_SP", $params);
}

function ActualizarServicioModel($id, $nombre, $descripcion, $precio)
{
    $params = [
        'P_ID_SERVICIO' => $id,
        'P_NOMBRE'      => $nombre,
        'P_DESCRIPCION' => $descripcion,
        'P_PRECIO'      => $precio
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_SERVICIO_TB_ACTUALIZAR_SP", $params);
}

function CambiarEstadoServicioModel($id, $nuevoEstado)
{
    $params = [
        'P_ID_SERVICIO' => $id,
        'P_ID_ESTADO'   => $nuevoEstado
    ];
    return EjecutarAccionSP(PKG_NAME . "FIDE_SERVICIO_TB_ELIMINAR_SP", $params);
}
?>