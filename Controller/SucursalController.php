<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/SucursalModel.php';

    function ConsultarSucursales()
    {
        return ConsultarSucursalesModel();
    } 

    function ConsultarSucursal($id)
    {
        return ConsultarSucursalModel($id);
    }

    // Lógica para Actualizar Sucursal
    if(isset($_POST["btnActualizarSucursal"]))
    {
        $idSucursal = $_POST["IDSucursal"];
        $nombre = $_POST["Nombre"];
        $idDireccion = $_POST["IDDireccion"];
        $telefono = $_POST["Telefono"];
        
        $resultado = ActualizarSucursalModel($idSucursal, $nombre, $idDireccion, $telefono); 

        if($resultado)
        {
            header("Location: ../../View/Sucursales/Sucursales.php");
            exit;
        }
        else
        {
            $_POST["Mensaje"] = "La información no se actualizó correctamente";
        }        
    }

    // Lógica para Agregar Sucursal
    if(isset($_POST["btnAgregarSucursal"]))
    {
        $nombre = $_POST["Nombre"];
        $telefono = $_POST["Telefono"];
        $idDireccion = $_POST["IDDireccion"]; // Necesario para tu SP INSERTAR
        $idEstado = 1;

        $resultado = AgregarSucursalModel($nombre, $idDireccion, $telefono, $idEstado);

        if($resultado)
        {
            header("Location: ../View/Sucursales/Sucursales.php");
            exit;
        }
        else
        {
            $_POST["Mensaje"] = "La información no se registró correctamente";
        }        
    }    

    // Lógica para Cambiar Estado (Eliminación lógica)
    if(isset($_POST["btnCambiarEstado"]))
    {
        $idSucursal = $_POST["IDSucursal"];
        $estadoActual = $_POST["EstadoActual"];
        
        // Lógica para alternar estado: si es 1 (Activo) lo pasa a 2 (Inactivo), si es 2 lo pasa a 1.
        $nuevoEstado = ($estadoActual == 1) ? 2 : 1; 

        $resultado = CambiarEstadoSucursalModel($idSucursal, $nuevoEstado);

        if($resultado)
        {
            header("Location: ../View/Sucursales/Sucursales.php");
            exit;
        }
        else
        {
            $_POST["Mensaje"] = "La información no se actualizó correctamente";
        }        
    }      

?>