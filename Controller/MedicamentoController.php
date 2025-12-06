<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/MedicamentoModel.php';

function ConsultarMedicamentos()
{
    return ConsultarMedicamentosModel();
}
function ConsultarMedicamento($id)
{
    return ConsultarMedicamentoPorIDModel($id);
}

if (isset($_POST["btnAgregarMedicamento"])) {
    $res = AgregarMedicamentoModel($_POST["Nombre"], $_POST["Principio"], $_POST["Presentacion"]);
    header("Location: ../View/Medicamentos/Medicamento.php");
}

if (isset($_POST["btnActualizarMedicamento"])) {
    $res = ActualizarMedicamentoModel($_POST["IDMedicamento"], $_POST["Nombre"], $_POST["Principio"], $_POST["Presentacion"]);
    header("Location: ../View/Medicamentos/Medicamento.php");
}

// NUEVO: Lógica de cambio de estado
if (isset($_POST["btnCambiarEstado"])) {
    $id = $_POST["IDMedicamento"];
    $estadoActual = $_POST["EstadoActual"];
    $nuevoEstado = ($estadoActual == 1) ? 2 : 1;

    CambiarEstadoMedicamentoModel($id, $nuevoEstado);
    header("Location: ../../View/Medicamentos/Medicamento.php");
}
