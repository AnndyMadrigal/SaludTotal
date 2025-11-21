<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php'; // O el archivo donde pusiste las funciones OCI8

    define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');

    function ConsultarSucursalesModel()
    {

        return EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_LISTAR_SP");
    }

    function ConsultarSucursalModel($id)
    {
        $sucursales = ConsultarSucursalesModel();

        // 1. Buscamos en la lista la que coincida con el ID que queremos editar
        foreach($sucursales as $fila) {
            if($fila['id_sucursal'] == $id) {
                return $fila; // si se encuentra devolvemos los datos
            }
        }

        //2. Si no lo encontramos, devolvemos null
        return null;
    }

    function ActualizarSucursalModel($id, $nombre, $id_direccion, $telefono)
    {
        $params = [
            'P_ID_SUCURSAL'  => $id,
            'P_NOMBRE'       => $nombre,
            'P_ID_DIRECCION' => $id_direccion,
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