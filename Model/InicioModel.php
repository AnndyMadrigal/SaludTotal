<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    function CrearCuentaModel($identificacion,$nombre,$correoElectronico,$contrasenna)
    {
        // NOTA: Esta función fallará con Oracle porque $context->query() es para MySQL.
        // OCI8 requiere oci_parse y oci_execute. 
        // Por ahora, dejémosla así para centrarnos en el LOGIN.
        try
        {
            $context = OpenConnection();
            // $sentencia = "CALL CrearCuenta(...)"; 
            // $resultado = $context -> query($sentencia); // ESTO DARÁ ERROR EN EL FUTURO
            CloseConnection($context);
            return false; 
        }
        catch(Exception $error)
        {
            return false;
        }
    }

    // FUNCIÓN DE LOGIN CORREGIDA PARA ORACLE Y TU ARQUITECTURA
    function ValidarCuentaModel($usuario, $contrasenna)
    {
        // 1. Usamos tu función de conexión existente
        $conn = OpenConnection(); 

        if (!$conn) {
            return null;
        }

        // 2. Preparar la llamada al SP dentro del Paquete
        // Asegúrate que el paquete FIDE_ADMINISTRACION_PKG existe en tu DB
        $sql = 'BEGIN FIDE_SALUDTOTAL_PKG.FIDE_USUARIO_TB_LISTAR_SP(:p_cursor); END;';
        
        $stmt = oci_parse($conn, $sql);

        // 3. Crear el cursor de salida para Oracle
        $cursor = oci_new_cursor($conn);

        // 4. Vincular el parámetro
        oci_bind_by_name($stmt, ':p_cursor', $cursor, -1, OCI_B_CURSOR);

        // 5. Ejecutar la sentencia
        if (!oci_execute($stmt)) {
            CloseConnection($conn);
            return null;
        }

        // 6. Ejecutar el cursor (¡Vital!)
        if (!oci_execute($cursor)) {
            CloseConnection($conn);
            return null;
        }

        $usuarioEncontrado = null;

        // 7. Iterar resultados
        while ($row = oci_fetch_assoc($cursor)) {
            
            // Oracle devuelve claves en MAYÚSCULAS. Ajusta según tus columnas reales.
            // Basado en tu contexto anterior, asumo estos nombres:
            $correoBD = isset($row['NOMBRE_USUARIO']) ? $row['NOMBRE_USUARIO'] : ''; 
            $passBD   = isset($row['CONTRASENNA']) ? $row['CONTRASENNA'] : '';
            
            // IMPORTANTE: A veces Oracle devuelve cadenas nulas o con espacios, usamos trim()
            if (trim($correoBD) === $usuario) {
                if (trim($passBD) === $contrasenna) {
                    $usuarioEncontrado = $row;
                    break; 
                }
            }
        }

        // 8. Liberar y cerrar
        oci_free_statement($stmt);
        oci_free_statement($cursor);
        CloseConnection($conn);

        return $usuarioEncontrado;
    }

    function ValidarCorreoModel($correoElectronico)
    {
        // Pendiente de migrar a sintaxis OCI8
        return null; 
    }

    function ActualizarContrasennaModel($ConsecutivoUsuario, $ContrasennaGenerada)
    {
        // Pendiente de migrar a sintaxis OCI8
        return false;
    }

    function ConsultarIndicadoresModel()
    {
        // Pendiente de migrar a sintaxis OCI8
        return null;
    } 
?>