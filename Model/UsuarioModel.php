
<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');

    /**
     * 
     * @param string 
     * @param array 
     * @return array|null 
     */
    function EjecutarConsultaUsuario($spName, $binds = [])
    {
        try
        {
            $conn = OpenConnection();
            if (!$conn) return null;

            // 1. Necesitamos un parámetro de salida para el cursor.
            $stmt = oci_parse($conn, "BEGIN $spName(:cursor_out); END;");
            
            // 2. Definir el parámetro de salida (el cursor)
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ':cursor_out', $cursor, -1, OCI_B_CURSOR);
            
            // 3. Bindear otros parámetros de entrada si los hay
            foreach ($binds as $key => $value) {
                oci_bind_by_name($stmt, $key, $binds[$key]);
            }

            // 4. Ejecutar la sentencia
            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception("Error al ejecutar $spName: " . $e['message']);
            }
            
            // 5. Ejecutar el cursor para obtener los datos
            oci_execute($cursor);

            $datos = [];
            while ($row = oci_fetch_assoc($cursor)) {
                // oci_fetch_assoc devuelve los nombres de las columnas en MAYÚSCULAS por defecto
                $datos[] = array_change_key_case($row, CASE_LOWER); 
            }

            // 6. Cerrar el cursor y la conexión
            oci_free_statement($cursor);
            oci_free_statement($stmt);
            CloseConnection($conn);

            return $datos;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return null;
        }
    }

    /**
     * 
     * @param string
     * @param array 
     * @return bool 
     */
    function EjecutarAccionUsuario($spName, $binds = [])
    {
        try
        {
            $conn = OpenConnection();
            if (!$conn) return false;

            // Construir la sentencia de llamada al SP (ej: BEGIN SP_NOMBRE(:p1, :p2); END;)
            $placeholders = implode(', ', array_keys($binds));
            $stmt = oci_parse($conn, "BEGIN $spName($placeholders); END;");

            // Bindear los parámetros
            foreach ($binds as $key => $value) {
                // Necesitamos pasar la variable por referencia para oci_bind_by_name
                oci_bind_by_name($stmt, $key, $binds[$key]); 
            }

            // Ejecutar la sentencia
            $resultado = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS); // Commit automático

            oci_free_statement($stmt);
            CloseConnection($conn);

            return $resultado;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return false;
        }
    }

   function ConsultarUsuariosModel()
    {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_USUARIO_TB_LISTAR_SP");
    }

    function ConsultarUsuarioModel($idUsuario)
    {
        $lista = ConsultarUsuariosModel();
        foreach($lista as $usuario) {
            if($usuario['id_usuario'] == $idUsuario) {
                return $usuario;
            }
        }
        return null;
    }

    function AgregarUsuarioModel($nombreUsuario, $contrasenna, $idPersonal, $idPaciente, $idRol)
    {
       
        $params = [
            'P_NOMBRE_USUARIO'  => $nombreUsuario,
            'P_CONTRASENNA'     => $contrasenna, 
            'P_ID_PERSONAL'     => empty($idPersonal) ? null : $idPersonal,
            'P_ID_PACIENTE'     => empty($idPaciente) ? null : $idPaciente,
            'P_ID_ROL_SISTEMA'  => $idRol,
            'P_ID_ESTADO'       => 1 
        ];

        return EjecutarAccionSP(PKG_NAME . "FIDE_USUARIO_TB_INSERTAR_SP", $params);
    }

    function ActualizarUsuarioModel($idUsuario, $idRol, $idEstado)
    {
        $params = [
            'P_ID_USUARIO'      => $idUsuario,
            'P_ID_ROL_SISTEMA'  => $idRol,
            'P_ID_ESTADO'       => $idEstado
        ];

        return EjecutarAccionSP(PKG_NAME . "FIDE_USUARIO_TB_ACTUALIZAR_SP", $params);
    }

    function CambiarEstadoUsuarioModel($idUsuario, $nuevoEstado)
    {
        // Obtenemos el usuario para no perder su rol actual al actualizar
        $usuario = ConsultarUsuarioModel($idUsuario);
        if(!$usuario) return false;

        $idRolActual = $usuario['id_rol_sistema']; //clave en minúscula

        return ActualizarUsuarioModel($idUsuario, $idRolActual, $nuevoEstado);
    }

    function ConsultarRolesSistemaModel()
    {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_ROL_SISTEMA_TB_LISTAR_SP");
    }

    function ConsultarEstadosModel()
    {
        return EjecutarRefCursorSP(PKG_NAME . "FIDE_ESTADO_TB_LISTAR_SP");
    }


?>