<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    function ConsultarProductosModel()
    {
        try
        {
            $context = OpenConnection();

            $sentencia = "CALL ConsultarProductos()";
            $resultado = $context -> query($sentencia);

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }

            $resultado->free();
            CloseConnection($context);

            return $datos;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return null;
        }
    }

    function ConsultarProductosPrincipalModel()
    {
        try
        {
            $context = OpenConnection();

            $sentencia = "CALL ConsultarProductosPrincipal()";
            $resultado = $context -> query($sentencia);

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }

            $resultado->free();
            CloseConnection($context);

            return $datos;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return null;
        }
    }

    function ConsultarProductoModel($id)
    {
        try
        {
            $context = OpenConnection();

            $sentencia = "CALL ConsultarProducto($id)";
            $resultado = $context -> query($sentencia);

            $datos = null;
            while ($row = $resultado->fetch_assoc()) {
                $datos = $row;
            }

            $resultado->free();
            CloseConnection($context);

            return $datos;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return null;
        }
    }

    function ActualizarProductoModel($consecutivoProducto,$nombre,$descripcion,$precio,$imagen,$cantidad)
    {
        try
        {
            $context = OpenConnection();

            $sentencia = "CALL ActualizarProducto('$consecutivoProducto', '$nombre', '$descripcion', '$precio', '$imagen','$cantidad')";
            $resultado = $context -> query($sentencia);

            CloseConnection($context);

            return $resultado;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return false;
        }
    }   

    function AgregarProductoModel($nombre,$descripcion,$precio,$imagen,$cantidad)
    {
        try
        {
            $context = OpenConnection();

            $sentencia = "CALL AgregarProducto('$nombre', '$descripcion', '$precio', '$imagen','$cantidad')";
            $resultado = $context -> query($sentencia);

            CloseConnection($context);

            return $resultado;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return false;
        }
    } 

    function CambiarEstadoProductoModel($consecutivoProducto)
    {
        try
        {
            $context = OpenConnection();

            $sentencia = "CALL CambiarEstadoProducto('$consecutivoProducto')";
            $resultado = $context -> query($sentencia);

            CloseConnection($context);

            return $resultado;
        }
        catch(Exception $error)
        {
            SaveError($error);
            return false;
        }
    } 

?>