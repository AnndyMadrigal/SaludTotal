<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php'; // O el archivo donde pusiste las funciones OCI8

    // Constantes para el paquete
    define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');

    function ConsultarSucursalesModel()
    {
        // Usa el SP FIDE_SUCURSAL_TB_LISTAR_SP
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_LISTAR_SP");
    }

    function ConsultarSucursalModel($id)
    {
        $params = ['P_ID_SUCURSAL' => $id];
        $resultado = EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_CONSULTAR_SP", $params);
        
        return empty($resultado) ? null : $resultado[0];
    }

    function ActualizarSucursalModel($id, $nombre, $id_direccion, $telefono) // <--- Agregamos $id_direccion aquí
    {
        $params = [
            'P_ID_SUCURSAL'  => $id,
            'P_NOMBRE'       => $nombre,
            'P_ID_DIRECCION' => $id_direccion, // <--- Enviando el ID de Dirección
            'P_TELEFONO'     => $telefono
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_SUCURSAL_TB_ACTUALIZAR_SP", $params);
    }  

    function AgregarSucursalModel($nombre, $id_direccion, $telefono, $id_estado = 1)
    {
        $params = [
            'P_NOMBRE' => $nombre,
            'P_ID_DIRECCION' => $id_direccion,
            'P_TELEFONO' => $telefono,
            'P_ID_ESTADO' => $id_estado
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_SUCURSAL_TB_INSERTAR_SP", $params);
    } 

    function CambiarEstadoSucursalModel($id, $nuevo_estado)
    {
        // Se usa ELIMINAR_SP para cambiar el estado de la sucursal (eliminación lógica)
        $params = [
            'P_ID_SUCURSAL' => $id,
            'P_ID_ESTADO' => $nuevo_estado 
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_SUCURSAL_TB_ELIMINAR_SP", $params);
    } 

?>