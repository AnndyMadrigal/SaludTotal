<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';
    define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');

    // ---LISTAR PACIENTES---
    function ConsultarPacientesModel() { 
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_PACIENTE_TB_LISTAR_SP"); 
    }

    // ---BUSCAR UNO---
    function ConsultarPacientePorIDModel($id) {
        $lista = ConsultarPacientesModel();
        foreach($lista as $p) { if($p['id_paciente'] == $id) return $p; }
        return null;
    }

    // ---INSERTAR DIRECCIÓN Y OBTENER ID---
    function CrearDireccionYObtenerID($idDistrito, $detalles) {
        $conn = OpenConnection();
        if(!$conn) return 0;

        $newId = 0; //inicializar en 0
        
        //usamos notación nombrada para evitar errores de orden
        $sql = "BEGIN " . PKG_NAME . "FIDE_DIRECCIONES_INSERTAR_V2_SP(
                    P_ID_DISTRITO => :p_dist, 
                    P_DETALLES => :p_det, 
                    P_NEW_ID => :p_out_id
                ); END;";
        
        $stmt = oci_parse($conn, $sql);
        
        //bind parameters
        oci_bind_by_name($stmt, ":p_dist", $idDistrito);
        oci_bind_by_name($stmt, ":p_det", $detalles);
        //bind del parámetro de SALIDA
        oci_bind_by_name($stmt, ":p_out_id", $newId, 32, SQLT_INT);
        
        //ejecutar con COMMIT explícito
        if(!oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($stmt);
            error_log("Error creando dirección: " . $e['message']); //revisa el log de PHP si falla
            CloseConnection($conn);
            return 0;
        }
        
        oci_free_statement($stmt);
        CloseConnection($conn);
        
        return $newId; //debería devolver el nuevo número (ej: 51)
    }

    // ---AGREGAR PACIENTE ---
    function AgregarPacienteModel($nombre, $ap1, $ap2, $fecha, $idDir) {
    // 1. Validación de seguridad
    if($idDir == 0 || $idDir == null) {
        return false; // Aquí es donde se detiene silenciosamente si falla la dirección
    }

    // 2. ELIMINAR CONVERSIÓN: Enviamos la fecha tal cual viene del HTML (YYYY-MM-DD)
    // porque ya configuramos Oracle en UtilesModel para que entienda este formato.
    
    $params = [
        'P_NOMBRE' => $nombre, 
        'P_APELLIDO_PATERNO' => $ap1, 
        'P_APELLIDO_MATERNO' => $ap2,
        'P_FECHA_NACIMIENTO' => $fecha, // <--- Úsala directa, sin date() ni strtotime()
        'P_ID_DIRECCION' => $idDir, 
        'P_ID_ESTADO' => 1
    ];
    
    return EjecutarAccionSP(PKG_NAME . "FIDE_PACIENTE_TB_INSERTAR_SP", $params);
    }

    function ActualizarPacienteModel($id, $nombre, $ap1, $ap2, $idDir) {
        $params = [
            'P_ID_PACIENTE' => $id, 'P_NOMBRE' => $nombre, 
            'P_APELLIDO_PATERNO' => $ap1, 'P_APELLIDO_MATERNO' => $ap2, 'P_ID_DIRECCION' => $idDir
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_PACIENTE_TB_ACTUALIZAR_SP", $params);
    }

    function CambiarEstadoPacienteModel($id, $nuevoEstado) {
        $params = ['P_ID_PACIENTE' => $id, 'P_ID_ESTADO' => $nuevoEstado];
        return EjecutarAccionSP(PKG_NAME . "FIDE_PACIENTE_TB_ELIMINAR_SP", $params);
    }

    function ConsultarDireccionesModel() {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_DIRECCIONES_TB_LISTAR_SP");
    }

    function ConsultarPacienteFullPorIDModel($id) {
        $data = EjecutarRefCursorSP(PKG_NAME . "FIDE_PACIENTES_OBTENER_FULL_SP", ['P_ID_PACIENTE' => $id]);
        return empty($data) ? null : $data[0];
    }

    function ActualizarDireccionModel($idDireccion, $idDistrito, $detalles) {
        $params = [
            'P_ID_DIRECCION' => $idDireccion,
            'P_ID_DISTRITO' => $idDistrito,
            'P_DETALLES' => $detalles
        ];
        return EjecutarAccionSP(PKG_NAME . "FIDE_DIRECCIONES_ACTUALIZAR_SP", $params);
    }
?>