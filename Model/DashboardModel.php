<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php'; // Tu archivo de conexión OCI8

    function ObtenerEstadisticasHospital()
    {
        try
        {
            $context = OpenConnection();
            $datos = [];

            // 1. Contar Sucursales
            $s1 = oci_parse($context, "SELECT COUNT(*) AS CANTIDAD FROM FIDE_SUCURSAL_TB WHERE ID_ESTADO = 1");
            oci_execute($s1);
            $r1 = oci_fetch_array($s1, OCI_ASSOC);
            $datos["SUCURSALES"] = $r1["CANTIDAD"];
            oci_free_statement($s1);

            // 2. Contar Personal
            $s2 = oci_parse($context, "SELECT COUNT(*) AS CANTIDAD FROM FIDE_PERSONAL_TB WHERE ID_ESTADO = 1");
            oci_execute($s2);
            $r2 = oci_fetch_array($s2, OCI_ASSOC);
            $datos["PERSONAL"] = $r2["CANTIDAD"];
            oci_free_statement($s2);

            // 3. Contar Usuarios
            $s3 = oci_parse($context, "SELECT COUNT(*) AS CANTIDAD FROM FIDE_USUARIO_TB WHERE ID_ESTADO = 1");
            oci_execute($s3);
            $r3 = oci_fetch_array($s3, OCI_ASSOC);
            $datos["USUARIOS"] = $r3["CANTIDAD"];
            oci_free_statement($s3);

            // 4. Contar Facturas (Total)
            $s4 = oci_parse($context, "SELECT COUNT(*) AS CANTIDAD FROM FIDE_FACTURA_TB");
            oci_execute($s4);
            $r4 = oci_fetch_array($s4, OCI_ASSOC);
            $datos["FACTURAS"] = $r4["CANTIDAD"];
            oci_free_statement($s4);

            CloseConnection($context);
            return $datos;
        }
        catch(Exception $error)
        {
            return ["SUCURSALES"=>0, "PERSONAL"=>0, "USUARIOS"=>0, "FACTURAS"=>0];
        }
    }
?>