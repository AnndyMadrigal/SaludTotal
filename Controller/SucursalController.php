<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/SucursalModel.php';

function ConsultarSucursales()
{
    return ConsultarSucursalesModel();
}
function ConsultarSucursalFull($id)
{
    return ConsultarSucursalFullPorIDModel($id);
}

//AGREGAR
if (isset($_POST["btnAgregarSucursal"])) {
    //1.Crear Dirección

    if (empty($_POST["cboDistrito"])) {
        //Redirigir con error o mostrar mensaje
        header("Location: ../View/Sucursales/Sucursales.php?error=DatosIncompletos");
        exit;
    }

    $idDistrito = $_POST["cboDistrito"];
    $detalles = $_POST["DetallesDireccion"];
    $idDireccion = CrearDireccionSucursalYObtenerID($idDistrito, $detalles);

    //2.Crear Sucursal
    $nombre = $_POST["Nombre"];
    $telefono = $_POST["Telefono"];

    $resultado = AgregarSucursalModel($nombre, $idDireccion, $telefono);

    if ($resultado) {
        header("Location: ../View/Sucursales/Sucursales.php");
        exit;
    } else {
        //Manejo básico de error
        header("Location: ../View/Sucursales/Sucursales.php?error=1");
        exit;
    }
}

//ACTUALIZAR
if (isset($_POST["btnActualizarSucursal"])) {
    //1.Actualizar Dirección existente
    ActualizarDireccionSucursalModel(
        $_POST["IDDireccion"],
        $_POST["cboDistrito"],
        $_POST["DetallesDireccion"]
    );

    //2.Actualizar Sucursal
    $idSucursal = $_POST["IDSucursal"];
    $nombre = $_POST["Nombre"];
    $telefono = $_POST["Telefono"];
    $idDireccion = $_POST["IDDireccion"];

    $resultado = ActualizarSucursalModel($idSucursal, $nombre, $idDireccion, $telefono);

    if ($resultado) {
        header("Location: ../View/Sucursales/Sucursales.php");
        exit;
    } else {
        header("Location: ../View/Sucursales/Sucursales.php?error=1");
        exit;
    }
}

//CAMBIAR ESTADO
if (isset($_POST["btnCambiarEstado"])) {
    $id = $_POST["ConsecutivoSucursal"];
    $estadoActual = $_POST["EstadoActual"];
    $nuevo = ($estadoActual == 1) ? 2 : 1;

    $resultado = CambiarEstadoSucursalModel($id, $nuevo);
    if ($resultado) {
        header("Location: ../../View/Sucursales/Sucursales.php");
        exit;
    }
}
