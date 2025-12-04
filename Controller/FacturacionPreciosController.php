<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';
    define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');

    header('Content-Type: application/json');
    $action = $_GET['action'] ?? '';

    if ($action == 'getPrecio') {
        $tipo = $_GET['tipo']; // 1=Servicio, 2=Medicamento
        $id = $_GET['id'];
        $precio = 0;

        $conn = OpenConnection();
        $sql = "BEGIN " . PKG_NAME . "FIDE_GET_PRECIO_ITEM_SP(:p_tipo, :p_id_item, :p_precio); END;";
        $stmt = oci_parse($conn, $sql);
        
        oci_bind_by_name($stmt, ":p_tipo", $tipo);
        oci_bind_by_name($stmt, ":p_id_item", $id);
        oci_bind_by_name($stmt, ":p_precio", $precio, 32, SQLT_NUM); // 32 es longitud buffer
        
        oci_execute($stmt);
        oci_free_statement($stmt);
        CloseConnection($conn);

        echo json_encode(['precio' => $precio]);
    }
?>