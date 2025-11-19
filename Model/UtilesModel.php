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
function OpenConnection()
{
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
function CloseConnection($conn)
{
    // oci_close() libera la conexión a la base de datos.
    return oci_close($conn);
}
?>