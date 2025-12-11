<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/PersonalModel.php';

function ConsultarPersonal()
{
    return ConsultarPersonalModel();
}
function ConsultarPersonalPorID($id)
{
    return ConsultarPersonalPorIDModel($id);
}
function ConsultarRolesPersonal()
{
    return ConsultarRolesPersonalModel();
}
function ConsultarSucursalesLista()
{
    return ConsultarSucursalesListarModel();
}

if (isset($_POST["btnAgregarPersonal"])) {
    $res = AgregarPersonalModel($_POST["Nombre"], $_POST["ApellidoP"], $_POST["ApellidoM"], $_POST["FechaContrato"], $_POST["IDSucursal"], $_POST["IDRol"]);
    header("Location: ../View/Personal/Personal.php" . ($res ? "" : "?error=1"));
}

if (isset($_POST["btnActualizarPersonal"])) {
    $res = ActualizarPersonalModel($_POST["IDPersonal"], $_POST["Nombre"], $_POST["ApellidoP"], $_POST["ApellidoM"], $_POST["IDSucursal"], $_POST["IDRol"]);
    header("Location: ../View/Personal/Personal.php" . ($res ? "" : "?error=1"));
}

if (isset($_POST["btnCambiarEstado"])) {
    $nuevo = ($_POST["EstadoActual"] == 1) ? 2 : 1;
    CambiarEstadoPersonalModel($_POST["IDPersonal"], $nuevo);
    header("Location: ../View/Personal/Personal.php");
}