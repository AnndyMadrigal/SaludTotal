<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/FacturaModel.php';

// Funciones para cargar combos
function ConsultarServicios()
{
    return ConsultarServiciosModel();
}

// PROCESAR FACTURA
if (isset($_POST["btnGuardarFactura"])) {
    // 1. Crear Cabecera
    // Por ahora no tenemos ID Cita en el form, mandamos NULL (Venta directa)
    // O si quieres implementarlo, sería un campo hidden.
    $idFacturaNueva = CrearEncabezadoFacturaModel(null);

    if ($idFacturaNueva > 0) {
        $detalles = $_POST['detalles']; // Array que viene del JS
        $linea = 1;

        if (is_array($detalles)) {
            foreach ($detalles as $d) {
                // Determinar si es servicio o inventario
                $idInv = null;
                $idServ = null;

                if ($d['tipo'] == '1') { // Servicio
                    $idServ = $d['id_item'];
                } else { // Medicamento (Inventario)
                    // OJO: Aquí el form debe enviar el ID_INVENTARIO, no el ID_MEDICAMENTO.
                    // En el JS haremos un ajuste para que el value del option sea ID_INVENTARIO
                    // (Asumiendo que el dropdown de medicamentos en realidad lista items de inventario disponibles)
                    // Si tu dropdown lista Medicamentos genéricos, necesitaríamos lógica extra para buscar inventario.
                    // Para simplificar, asumiremos que en el form cargas "Inventario Disponible".
                    $idInv = $d['id_item'];

                    /* NOTA IMPORTANTE: Si el dropdown muestra ID_MEDICAMENTO, 
                           necesitamos buscar un ID_INVENTARIO disponible en la BD.
                           Como este es un ejemplo "Web", lo ideal es que el dropdown 
                           liste "Tylenol (Stock: 50)" y su value sea el ID_INVENTARIO. */
                }

                $cantidad = $d['cantidad'];

                // Insertamos (La BD calcula precios)
                AgregarDetalleFacturaModel($idFacturaNueva, $linea, $idInv, $idServ, $cantidad);
                $linea++;
            }
        }

        // Redireccionar a éxito o ver factura
        header("Location: ../View/Facturacion/MisFacturas.php?msg=Factura " . $idFacturaNueva . " creada");
        exit;
    } else {
        echo "Error al crear encabezado de factura.";
    }
}
