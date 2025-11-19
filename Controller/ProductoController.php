<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/ProductoModel.php';

    function ConsultarProductos()
    {
        return ConsultarProductosModel();
    }

    function ConsultarProductosPrincipal()
    {
        return ConsultarProductosPrincipalModel();
    }  

    function ConsultarProducto($id)
    {
        return ConsultarProductoModel($id);
    }

    if(isset($_POST["btnActualizarProducto"]))
    {
        $consecutivoProducto = $_POST["ConsecutivoProducto"];
        $nombre = $_POST["Nombre"];
        $descripcion = $_POST["Descripcion"];
        $precio = $_POST["Precio"];
        $cantidad = $_POST["Cantidad"];
        $imagen = '';

        if($_FILES["ImagenProducto"]["name"] != "")
        {
            $imagen = '../img/' . $_FILES["ImagenProducto"]["name"];
            $origen = $_FILES["ImagenProducto"]["tmp_name"];
            $destino = $_SERVER["DOCUMENT_ROOT"] . '/SaludTotal/View/img/' . $_FILES["ImagenProducto"]["name"];
            copy($origen,$destino);
        }       

        $resultado = ActualizarProductoModel($consecutivoProducto,$nombre,$descripcion,$precio,$imagen,$cantidad);

        if($resultado)
        {
            header("Location: ../../View/Productos/Productos.php");
            exit;
        }
        else
        {
            $_POST["Mensaje"] = "La información no se actualizó correctamente";
        }        
    }

    if(isset($_POST["btnAgregarProducto"]))
    {
        $nombre = $_POST["Nombre"];
        $descripcion = $_POST["Descripcion"];
        $precio = $_POST["Precio"];
        $cantidad = $_POST["Cantidad"];
        $imagen = '../img/' . $_FILES["ImagenProducto"]["name"];
        
        $origen = $_FILES["ImagenProducto"]["tmp_name"];
        $destino = $_SERVER["DOCUMENT_ROOT"] . '/SaludTotal/View/img/' . $_FILES["ImagenProducto"]["name"];
        copy($origen,$destino);      

        $resultado = AgregarProductoModel($nombre,$descripcion,$precio,$imagen,$cantidad);

        if($resultado)
        {
            header("Location: ../../View/Productos/Productos.php");
            exit;
        }
        else
        {
            $_POST["Mensaje"] = "La información no se registró correctamente";
        }        
    }    

    if(isset($_POST["btnCambiarEstado"]))
    {
        $consecutivoProducto = $_POST["ConsecutivoProducto"];
        
        $resultado = CambiarEstadoProductoModel($consecutivoProducto);

        if($resultado)
        {
            header("Location: ../../View/Productos/Productos.php");
            exit;
        }
        else
        {
            $_POST["Mensaje"] = "La información no se actualizó correctamente";
        }        
    }      

?>