<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    function ConsultarPersonalModel() {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_PERSONAL_TB_LISTAR_SP");
    }

    function ConsultarPersonalPorIDModel($id) {
        $lista = ConsultarPersonalModel();
        foreach($lista as $p) { if($p['id_personal'] == $id) return $p; }
        return null;
    }

    function AgregarPersonalModel($nombre, $ap1, $ap2, $fecha, $idSucursal, $idRol) {
        $params = [
            'P_NOMBRE' => $nombre, 'P_APELLIDO_PATERNO' => $ap1, 'P_APELLIDO_MATERNO' => $ap2,
            'P_FECHA_CONTRATACION' => $fecha, 'P_ID_SUCURSAL' => $idSucursal,
            'P_ID_ROL_PERSONAL' => $idRol, 'P_ID_ESTADO' => 1
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_PERSONAL_TB_INSERTAR_SP", $params);
    }

    function ActualizarPersonalModel($id, $nombre, $ap1, $ap2, $idSucursal, $idRol) {
        $params = [
            'P_ID_PERSONAL' => $id, 'P_NOMBRE' => $nombre, 
            'P_APELLIDO_PATERNO' => $ap1, 'P_APELLIDO_MATERNO' => $ap2,
            'P_ID_SUCURSAL' => $idSucursal, 'P_ID_ROL_PERSONAL' => $idRol
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_PERSONAL_TB_ACTUALIZAR_SP", $params);
    }

    function CambiarEstadoPersonalModel($id, $nuevoEstado) {
        $params = ['P_ID_PERSONAL' => $id, 'P_ID_ESTADO' => $nuevoEstado];
        return EjecutarAccionSP(PKG_NAME . "FIDE_PERSONAL_TB_ELIMINAR_SP", $params);
    }

    // Listas para Dropdowns
    function ConsultarRolesPersonalModel() {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_ROL_PERSONAL_TB_LISTAR_SP");
    }
    
    // Reutilizamos el SP de sucursales que ya tenías
    function ConsultarSucursalesListarModel() {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_LISTAR_SP");
    }
?>