// UsuarioModel.php (Adaptado para Oracle OCI8)
<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

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
                // En PHP, si se bindea un valor de un array, ya es una referencia.
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

    // --- Funciones del CRUD de USUARIOS ---

    function ConsultarUsuariosModel()
    {
        // El SP debe ser algo como: CREATE OR REPLACE PROCEDURE SP_CONSULTAR_USUARIOS(cursor_out OUT SYS_REFCURSOR)
        return EjecutarConsultaUsuario('SP_CONSULTAR_USUARIOS');
    }

    function ConsultarUsuarioModel($id)
    {
        // Este SP devuelve solo un registro, pero usa la misma lógica de cursor.
        // El SP debe ser algo como: CREATE OR REPLACE PROCEDURE SP_CONSULTAR_USUARIO(id_in IN NUMBER, cursor_out OUT SYS_REFCURSOR)
        $datos = EjecutarConsultaUsuario('SP_CONSULTAR_USUARIO', [':ID_IN' => $id]);
        return count($datos) > 0 ? $datos[0] : null; // Retorna solo el primer registro
    }

    function AgregarUsuarioModel($nombre,$apellido,$cedula,$email,$rol,$password)
    {
        // Reemplaza con los nombres de tus parámetros de SP
        $binds = [
            ':NOMBRE_IN' => $nombre,
            ':APELLIDO_IN' => $apellido,
            ':CEDULA_IN' => $cedula,
            ':EMAIL_IN' => $email,
            ':ROL_IN' => $rol,
            ':PASSWORD_IN' => $password
        ];
        return EjecutarAccionUsuario('SP_AGREGAR_USUARIO', $binds);
    }
    
    function ActualizarUsuarioModel($idUsuario,$nombre,$apellido,$cedula,$email,$rol)
    {
        // Reemplaza con los nombres de tus parámetros de SP
        $binds = [
            ':ID_USUARIO_IN' => $idUsuario,
            ':NOMBRE_IN' => $nombre,
            ':APELLIDO_IN' => $apellido,
            ':CEDULA_IN' => $cedula,
            ':EMAIL_IN' => $email,
            ':ROL_IN' => $rol
        ];
        return EjecutarAccionUsuario('SP_ACTUALIZAR_USUARIO', $binds);
    }

    function CambiarEstadoUsuarioModel($idUsuario)
    {
        $binds = [':ID_USUARIO_IN' => $idUsuario];
        return EjecutarAccionUsuario('SP_CAMBIAR_ESTADO_USUARIO', $binds);
    }

    // (Otras funciones de ProductoModel como ConsultarProductosPrincipalModel no son necesarias y se eliminan)
?>