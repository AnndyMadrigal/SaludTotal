<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/InventarioModel.php';

function ConsultarInventario()
{
    return ConsultarInventarioModel();
}
function ConsultarInventarioPorID($id)
{
    return ConsultarInventarioPorIDModel($id);
}
function ObtenerSucursales()
{
    return ListarSucursalesInv();
}
function ObtenerMedicamentos()
{
    return ListarMedicamentosInv();
}

if (isset($_POST["btnAgregarInventario"])) {
    AgregarInventarioModel($_POST["IDSucursal"], $_POST["IDMedicamento"], $_POST["Stock"], $_POST["FechaVenc"]);
    header("Location: ../View/Inventario/Inventario.php");
}

if (isset($_POST["btnActualizarInventario"])) {
    ActualizarInventarioModel($_POST["IDInventario"], $_POST["Stock"], $_POST["FechaVenc"], $_POST["Estado"]);
    header("Location: ../View/Inventario/Inventario.php");
}

if (isset($_POST["btnCambiarEstado"])) {
    $nuevo = ($_POST["EstadoActual"] == 1) ? 2 : 1;
    CambiarEstadoInventarioModel($_POST["IDInventario"], $nuevo);
    header("Location: ../View/Inventario/Inventario.php");
}
