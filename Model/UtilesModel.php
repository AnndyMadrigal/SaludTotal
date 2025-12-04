<?php
// Define las credenciales y la cadena de conexión de Oracle
define('ORACLE_USER', 'FIDE_SALUDTOTAL_BD'); // Reemplaza con tu usuario
define('ORACLE_PASS', '123'); // Reemplaza con tu contraseña
define('ORACLE_CONN_STRING', 'localhost/XE'); // Por ejemplo: 'localhost/XE'

if (!defined('PKG_NAME')) {
        define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');
    }

function OpenConnection() {
    $conn = @oci_connect(ORACLE_USER, ORACLE_PASS, ORACLE_CONN_STRING, 'AL32UTF8');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        return false;
    }

    oci_execute(oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD'"));

    return $conn;
}


function CloseConnection($conn) {
    return oci_close($conn);
}

define('P_CURSOR_NAME', 'P_CURSOR'); //nombre del parámetro REF CURSOR estándar


function EjecutarRefCursorSP($sp_name, $params_in = [])
{
    try
    {
        $conn = OpenConnection();
        
        $param_list = [];
        foreach ($params_in as $name => $value) {
            $param_list[] = "$name => :$name";
        }
        $param_list[] = P_CURSOR_NAME . " => :" . P_CURSOR_NAME;
        $sql = "BEGIN $sp_name(" . implode(', ', $param_list) . "); END;";

        $stmt = oci_parse($conn, $sql);

        //bindear parámetros de entrada
        foreach ($params_in as $name => $value) {
            oci_bind_by_name($stmt, ":$name", $params_in[$name], -1); 
        }
        
        //definir y bindear el parámetro de salida (REFCURSOR)
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":" . P_CURSOR_NAME, $cursor, -1, OCI_B_CURSOR);

        oci_execute($stmt); //ejecutar el SP
        oci_execute($cursor); //ejecutar el REF CURSOR para obtener los datos

        $datos = [];
        while ($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) {
            //convertir claves a minúsculas, ya que OCI devuelve mayúsculas por defecto
            $datos[] = array_change_key_case($row, CASE_LOWER);
        }

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


function EjecutarAccionSP($sp_name, $params)
{
    try
    {
        $conn = OpenConnection();
        
        //Construir la cadena del SP: BEGIN PAQUETE.SP(:param1, :param2); END;
        $param_names = [];
        foreach ($params as $name => $value) {
            $param_names[] = "$name => :$name";
        }
        
        $sql = "BEGIN $sp_name(" . implode(', ', $param_names) . "); END;";

        $stmt = oci_parse($conn, $sql);

        //Bindear parámetros
        foreach ($params as $name => $value) {
            oci_bind_by_name($stmt, ":$name", $params[$name], -1);
        }

        $resultado = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);

        if (!$resultado) {
            $e = oci_error($stmt);
            throw new Exception("Error Oracle: " . $e['message']);
        }

        oci_free_statement($stmt);
        CloseConnection($conn);

        return true;
    }
    catch(Exception $error)
    {
        SaveError($error);
        return false;
    }
}

function SaveError($e) {
    function SaveError($e) {
    //Guardar en log (lo que ya tenías)
    error_log("ERROR BD: " . $e->getMessage());
}
}

?>