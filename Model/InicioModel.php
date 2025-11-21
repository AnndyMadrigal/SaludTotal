<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    function CrearCuentaModel($identificacion,$nombre,$correoElectronico,$contrasenna)
    {
        try
        {
            $context = OpenConnection();
            CloseConnection($context);
            return false; 
        }
        catch(Exception $error)
        {
            return false;
        }
    }

    // FUNCIÓN DE LOGIN
    function ValidarCuentaModel($usuario, $contrasenna)
    {
        $conn = OpenConnection(); 

        if (!$conn) {
            return null;
        }
        $sql = 'BEGIN FIDE_SALUDTOTAL_PKG.FIDE_USUARIO_TB_LISTAR_SP(:p_cursor); END;';
        
        $stmt = oci_parse($conn, $sql);

        //Crear el cursor de salida para Oracle
        $cursor = oci_new_cursor($conn);

        //Vincular el parámetro
        oci_bind_by_name($stmt, ':p_cursor', $cursor, -1, OCI_B_CURSOR);

        //Ejecutar la sentencia
        if (!oci_execute($stmt)) {
            CloseConnection($conn);
            return null;
        }

        //Ejecutar el cursor
        if (!oci_execute($cursor)) {
            CloseConnection($conn);
            return null;
        }

        $usuarioEncontrado = null;

        //Iterar resultados
        while ($row = oci_fetch_assoc($cursor)) {
            
            $correoBD = isset($row['NOMBRE_USUARIO']) ? $row['NOMBRE_USUARIO'] : ''; 
            $passBD   = isset($row['CONTRASENNA']) ? $row['CONTRASENNA'] : '';
            
            // usamos trim por si oracle devuelve espacios vacios
            if (trim($correoBD) === $usuario) {
                if (trim($passBD) === $contrasenna) {
                    $usuarioEncontrado = $row;
                    break; 
                }
            }
        }

        //Liberar y cerrar
        oci_free_statement($stmt);
        oci_free_statement($cursor);
        CloseConnection($conn);

        return $usuarioEncontrado;
    }

    function ActualizarContrasennaModel($ConsecutivoUsuario, $ContrasennaGenerada)
    {
        // Pendiente
        return false;
    }
?>