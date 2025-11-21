<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    function ObtenerEstadisticasHospital()
    {
        try
        {
            $context = OpenConnection();
            if (!$context) {
                return ["SUCURSALES"=>0, "PERSONAL"=>0, "USUARIOS"=>0, "FACTURAS"=>0];
            }

            //llamada al SP con 4 variables de salida
            $sql = "BEGIN FIDE_SALUDTOTAL_PKG.FIDE_DASHBOARD_SP(:p1, :p2, :p3, :p4); END;";
            $stmt = oci_parse($context, $sql);

            //inicializamos las variables del php que reciben los datos
            $cantSucursales = 0;
            $cantPersonal = 0;
            $cantUsuarios = 0;
            $cantFacturas = 0;

            //bindeamos las variables de PHP a los parámetros de Oracle
            //el tercer parámetro (32) es la longitud máxima, el cuarto es el tipo (Entero)
            oci_bind_by_name($stmt, ":p1", $cantSucursales, 6, SQLT_INT);
            oci_bind_by_name($stmt, ":p2", $cantPersonal, 6, SQLT_INT);
            oci_bind_by_name($stmt, ":p3", $cantUsuarios, 6, SQLT_INT);
            oci_bind_by_name($stmt, ":p4", $cantFacturas, 6, SQLT_INT);

            //ejecutamos
            oci_execute($stmt);
            
            //liberamos recursos
            oci_free_statement($stmt);
            CloseConnection($context);

            //devolvemos el array con las claves que espera la vista
            return [
                "SUCURSALES" => $cantSucursales,
                "PERSONAL"   => $cantPersonal,
                "USUARIOS"   => $cantUsuarios,
                "FACTURAS"   => $cantFacturas
            ];
        }
        catch(Exception $error)
        {
            //en caso de error, devolvemos 0 para no romper la interfaz
            return ["SUCURSALES"=>0, "PERSONAL"=>0, "USUARIOS"=>0, "FACTURAS"=>0];
        }
    }
?>