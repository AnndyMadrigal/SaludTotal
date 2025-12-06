<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/ServiciosModel.php';

function ConsultarServicios()
{
    return ConsultarServiciosModel();
}

function ConsultarServicio($id)
{
    return ConsultarServicioPorIDModel($id);
}

//1.Agregar
if (isset($_POST["btnAgregarServicio"])) {
    $resultado = AgregarServicioModel($_POST["Nombre"], $_POST["Descripcion"], $_POST["Precio"]);
    header("Location: ../View/Servicios/Servicios.php");
    exit;
}

//2.Actualizar
if (isset($_POST["btnActualizarServicio"])) {
    $resultado = ActualizarServicioModel(
        $_POST["IDServicio"], 
        $_POST["Nombre"], 
        $_POST["Descripcion"], 
        $_POST["Precio"]
    );
    
    header("Location: ../View/Servicios/Servicios.php");
    exit;
}

//3.Cambiar Estado
if (isset($_POST["btnCambiarEstado"])) {
    $id = $_POST["IDServicio"];
    $estadoActual = $_POST["EstadoActual"];
    $nuevoEstado = ($estadoActual == 1) ? 2 : 1;

    CambiarEstadoServicioModel($id, $nuevoEstado);
    header("Location: ../View/Servicios/Servicios.php");
    exit;
}
?>