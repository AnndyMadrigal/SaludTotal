<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    function ConsultarServiciosModel() {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_SERVICIO_TB_LISTAR_SP");
    }

    // Insertar Cabecera (Solo enviamos datos básicos)
    function CrearEncabezadoFacturaModel($idCita) {
        $conn = OpenConnection();
        $newId = 0;
        
        // Nótese que ya NO enviamos montos. El SP los pone en 0.
        $sql = "BEGIN " . PKG_NAME . "FIDE_FACTURA_INSERTAR_V2_SP(:p_cita, :p_out_id); END;";
        $stmt = oci_parse($conn, $sql);
        
        // Manejo de nulo para cita
        $valCita = empty($idCita) ? null : $idCita;
        
        oci_bind_by_name($stmt, ":p_cita", $valCita);
        oci_bind_by_name($stmt, ":p_out_id", $newId, 32, SQLT_INT); // ID Compuesto devuelto
        
        if(!oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
            CloseConnection($conn);
            return 0;
        }
        
        oci_free_statement($stmt);
        CloseConnection($conn);
        return $newId;
    }

    // Insertar Detalle (Solo enviamos QUÉ y CUÁNTO)
    function AgregarDetalleFacturaModel($idFactura, $linea, $idInv, $idServ, $cantidad) {
        $params = [
            'P_ID_FACTURA'    => $idFactura,
            'P_ID_LINEA'         => $linea,
            'P_ID_INVENTARIO' => empty($idInv) ? null : $idInv,
            'P_ID_SERVICIO'   => empty($idServ) ? null : $idServ,
            'P_CANTIDAD'      => $cantidad
            // ¡OJO! No enviamos ni precio ni subtotal. Oracle los busca.
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_FACTURA_DETALLE_INSERT_SP", $params);
    }
?>