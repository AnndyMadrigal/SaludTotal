<?php
// Define las credenciales y la cadena de conexión de Oracle
define('ORACLE_USER', 'FIDE_SALUDTOTAL_BD'); // Reemplaza con tu usuario
define('ORACLE_PASS', '123'); // Reemplaza con tu contraseña
define('ORACLE_CONN_STRING', 'localhost/XE'); // Por ejemplo: 'localhost/XE', '192.168.1.10:1521/ORCL', o un nombre TNS

/**
 * Establece una conexión a la base de datos Oracle.
 *
 * @return resource|false El identificador de conexión si tiene éxito, o false si falla.
 */
function OpenConnection() {
    $conn = @oci_connect(ORACLE_USER, ORACLE_PASS, ORACLE_CONN_STRING);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        return false;
    }
    return $conn;
}

/**
 * Cierra la conexión a la base de datos Oracle.
 *
 * @param resource $conn El identificador de conexión devuelto por OpenConnection().
 * @return bool True si la desconexión fue exitosa.
 */
function CloseConnection($conn) {
    return oci_close($conn);
}

define('P_CURSOR_NAME', 'P_CURSOR'); // Nombre del parámetro REF CURSOR estándar

/**
 * Ejecuta un SP de Oracle que devuelve un SYS_REFCURSOR.
 * @param string $sp_name Nombre completo del SP (ej. FIDE_SALUDTOTAL_PKG.FIDE_SUCURSAL_TB_LISTAR_SP).
 * @param array $params_in Array asociativo de parámetros de entrada (claves: nombre del parámetro del SP).
 * @return array|null Array de filas (claves en minúsculas) o null si hay error.
 */
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

        // Bindear parámetros de entrada
        foreach ($params_in as $name => $value) {
            // Se bindea por referencia, por eso $params_in[$name]
            oci_bind_by_name($stmt, ":$name", $params_in[$name], -1); 
        }
        
        // Definir y bindear el parámetro de salida (REF CURSOR)
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":" . P_CURSOR_NAME, $cursor, -1, OCI_B_CURSOR);

        oci_execute($stmt); // Ejecutar el SP
        oci_execute($cursor); // Ejecutar el REF CURSOR para obtener los datos

        $datos = [];
        while ($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) {
            // Convertir claves a minúsculas, ya que OCI devuelve mayúsculas por defecto
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

/**
 * Ejecuta un Stored Procedure de Oracle de acción (INSERT/UPDATE/DELETE).
 * @param string $sp_name Nombre completo del SP.
 * @param array $params Array asociativo de parámetros de entrada.
 * @return bool True si la ejecución fue exitosa y se hizo COMMIT.
 */
function EjecutarAccionSP($sp_name, $params)
{
    try
    {
        $conn = OpenConnection();
        
        // Construir la cadena del SP: BEGIN PAQUETE.SP(:param1, :param2); END;
        $param_names = [];
        foreach ($params as $name => $value) {
            $param_names[] = "$name => :$name";
        }
        
        $sql = "BEGIN $sp_name(" . implode(', ', $param_names) . "); END;";

        $stmt = oci_parse($conn, $sql);

        // Bindear parámetros
        foreach ($params as $name => $value) {
            // IMPORTANTE: Asignar el valor a una variable temporal para pasar por referencia
            // OCI8 requiere pasar variables, no valores directos en el bucle a veces.
            // Sin embargo, bind_by_name funciona, pero hay que tener cuidado con el scope.
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
        SaveError($error); // Ahora sí funcionará porque la definimos abajo
        return false;
    }
}

function SaveError($e) {
    // Guardar el error en el log de errores de PHP (apache error.log o php_error.log)
    error_log("ERROR BD: " . $e->getMessage());
    // Opcional: Imprimir en pantalla si estás en desarrollo (CUIDADO EN PRODUCCION)
    echo "";
}

?>