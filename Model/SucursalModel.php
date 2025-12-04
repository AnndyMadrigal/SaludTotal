<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    //---CONSULTAS---
    function ConsultarSucursalesModel() {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_TB_LISTAR_SP");
    }

    function ConsultarSucursalFullPorIDModel($id) {
        $data = EjecutarRefCursorSP(PKG_NAME . "FIDE_SUCURSAL_OBTENER_FULL_SP", ['P_ID_SUCURSAL' => $id]);
        return empty($data) ? null : $data[0];
    }

    //---DIRECCIÓN---
    function CrearDireccionSucursalYObtenerID($idDistrito, $detalles) {
        $conn = OpenConnection();
        if(!$conn) return 0;

        $newId = 0;
        $sql = "BEGIN " . PKG_NAME . "FIDE_DIRECCIONES_INSERTAR_V2_SP(P_ID_DISTRITO => :p_dist, P_DETALLES => :p_det, P_NEW_ID => :p_out_id); END;";
        $stmt = oci_parse($conn, $sql);
        
        oci_bind_by_name($stmt, ":p_dist", $idDistrito);
        oci_bind_by_name($stmt, ":p_det", $detalles);
        oci_bind_by_name($stmt, ":p_out_id", $newId, 32, SQLT_INT);
        
        if(!oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
            error_log("Error creando dirección sucursal");
            CloseConnection($conn);
            return 0;
        }
        
        oci_free_statement($stmt);
        CloseConnection($conn);
        return $newId;
    }

    function ActualizarDireccionSucursalModel($idDireccion, $idDistrito, $detalles) {
        $params = [
            'P_ID_DIRECCION' => $idDireccion,
            'P_ID_DISTRITO' => $idDistrito,
            'P_DETALLES' => $detalles
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_DIRECCIONES_ACTUALIZAR_SP", $params);
    }

    //---ACCIONES SUCURSAL---
    function AgregarSucursalModel($nombre, $idDireccion, $telefono) {
        if($idDireccion == 0) return false;

        $params = [
            'P_NOMBRE' => $nombre,
            'P_ID_DIRECCION' => $idDireccion,
            'P_TELEFONO' => $telefono,
            'P_ID_ESTADO' => 1
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_SUCURSAL_TB_INSERTAR_SP", $params);
    }

    function ActualizarSucursalModel($id, $nombre, $idDireccion, $telefono) {
        $params = [
            'P_ID_SUCURSAL' => $id,
            'P_NOMBRE' => $nombre,
            'P_ID_DIRECCION' => $idDireccion,
            'P_TELEFONO' => $telefono
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_SUCURSAL_TB_ACTUALIZAR_SP", $params);
    } 

    function CambiarEstadoSucursalModel($id, $nuevoEstado) {
        $params = ['P_ID_SUCURSAL' => $id, 'P_ID_ESTADO' => $nuevoEstado];
        return EjecutarAccionSP(PKG_NAME . "FIDE_SUCURSAL_TB_ELIMINAR_SP", $params);
    } 
?>