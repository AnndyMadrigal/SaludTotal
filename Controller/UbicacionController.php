<?php
    // Incluir el modelo de utilidades que ya maneja la conexion y constantes
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';

    // Establecer cabecera JSON para que el navegador sepa que esperar
    header('Content-Type: application/json');

    // Obtener la accion y el ID (con validacion basica)
    $action = $_GET['action'] ?? '';
    $id = $_GET['id'] ?? 0;

    $datos = [];

    try {
        switch($action) {
            case 'getProvincias':
                // Reutilizamos la funcion generica de UtilesModel
                $datos = EjecutarRefCursorSP(PKG_NAME . "FIDE_PROVINCIAS_LISTAR_SP");
                break;

            case 'getCantones':
                // Enviamos el parametro con el nombre exacto que espera el SP
                $params = ['P_ID_PROVINCIA' => $id];
                $datos = EjecutarRefCursorSP(PKG_NAME . "FIDE_CANTONES_POR_PROVINCIA_SP", $params);
                break;

            case 'getDistritos':
                //Enviamos el parametro con el nombre exacto que espera el SP
                $params = ['P_ID_CANTON' => $id];
                $datos = EjecutarRefCursorSP(PKG_NAME . "FIDE_DISTRITOS_POR_CANTON_SP", $params);
                break;
        }
    } catch (Exception $e) {
        //En caso de error, devolvemos array vacio para no romper el JS
        $datos = [];
    }

    //devolver el JSON limpio
    echo json_encode($datos);
?>