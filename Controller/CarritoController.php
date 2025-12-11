<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/CarritoModel.php';

//Asegúrate de tener el usuario en sesión. Si no, usa un default para pruebas.
$usuarioActual = $_SESSION['NombreUsuario'] ?? 'admin';

//---AGREGAR MEDICAMENTO ---
if (isset($_POST['btnAgregarMedicamento'])) {
    $idMed = $_POST['id_medicamento'];
    AgregarItemCarritoModel($usuarioActual, null, $idMed);
    header("Location: ../View/Medicamentos/Medicamento.php"); // Vuelve a la lista
    exit;
}

//---AGREGAR SERVICIO ---
if (isset($_POST['btnAgregarServicio'])) {
    $idServ = $_POST['id_servicio'];
    AgregarItemCarritoModel($usuarioActual, $idServ, null);
    header("Location: ../View/Servicios/Servicios.php"); // Vuelve a la lista
    exit;
}

//---ELIMINAR DEL CARRITO ---
if (isset($_POST['btnEliminarItem'])) {
    $idCarrito = $_POST['id_carrito'];
    EliminarItemCarritoModel($idCarrito);
    header("Location: ../View/Carrito/MiCarrito.php");
    exit;
}

//---PAGAR (FACTURAR) ---
if (isset($_POST['btnRealizarPago'])) {

    //obtener datos del formulario
    $idCita = $_POST["cboCita"]; // Viene del dropdown

    //validación Básica
    if (empty($idCita)) {
        //usamos SESSION para el mensaje porque POST se pierde en el redirect
        $_SESSION["Error"] = "Debe seleccionar una Cita válida para facturar.";
        header("Location: ../View/Carrito/MiCarrito.php");
        exit;
    }

    //pasamos el usuario logueado y la cita seleccionada
    $idFacturaCreada = RealizarPagoCarritoModel($usuarioActual, $idCita);

    //evaluar Resultado
    if ($idFacturaCreada > 0) {
        //EXITO
        $_SESSION["Mensaje"] = "¡Factura generada y pago procesado correctamente!";

        //dirigir a ver facturas (de momento no)
        header("Location: ../View/Facturacion/VerFactura.php?id=" . $idFacturaCreada);
        exit;
    } else {
        //ERROR
        $_SESSION["Error"] = "ERROR: No se pudo procesar el pago. Verifique el inventario o la conexión.";
        header("Location: ../View/Carrito/MiCarrito.php");
        exit;
    }
}

//---FUNCIONES PARA LLENAR VISTAS ---
function ObtenerCarrito()
{
    global $usuarioActual;
    return ConsultarCarritoModel($usuarioActual);
}

function ObtenerCitasCombo()
{
    return ConsultarCitasPendientesModel();
}
