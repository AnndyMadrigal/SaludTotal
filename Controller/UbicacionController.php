<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UtilesModel.php';
    define('PKG_NAME', 'FIDE_SALUDTOTAL_PKG.');


    function Listar($sp, $paramName = null, $paramValue = null) {
        $conn = OpenConnection();
        if (!$conn) return []; 

        $sql = "BEGIN " . PKG_NAME . "$sp(P_CURSOR => :cursor";
        
        if($paramName) {
            $sql .= ", $paramName => :v_param"; 
        }
        
        $sql .= "); END;";
        
        $stmt = oci_parse($conn, $sql);
        
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
        
        
        if($paramName) {
            
            oci_bind_by_name($stmt, ":v_param", $paramValue);
        }
        
        // ejecutamos
        $r = oci_execute($stmt);
        if(!$r) {
            //si falla, retornamos vacío para no romper el JSON
            return [];
        }

        //ejecución del cursor
        $r_cursor = oci_execute($cursor);
        if(!$r_cursor) {
            return [];
        }
        
        $data = [];
        while ($row = oci_fetch_assoc($cursor)) {
            //convertimos a minúsculas para que el JS lo lea fácil (id_canton, nombre_canton)
            $data[] = array_change_key_case($row, CASE_LOWER);
        }
        
        oci_free_statement($stmt);
        oci_free_statement($cursor);
        CloseConnection($conn);
        
        return $data;
    }

    
    //le indicamos al navegador que la respuesta es JSON
    header('Content-Type: application/json');

    $action = $_GET['action'] ?? '';

    if ($action == 'getProvincias') {
        echo json_encode(Listar("FIDE_PROVINCIAS_LISTAR_SP"));
    }
    elseif ($action == 'getCantones') {
        $id = $_GET['id'];
        //Importante: El nombre del parámetro debe coincidir EXACTO con el del SP en Oracle
        echo json_encode(Listar("FIDE_CANTONES_POR_PROVINCIA_SP", "P_ID_PROVINCIA", $id));
    }
    elseif ($action == 'getDistritos') {
        $id = $_GET['id'];
        echo json_encode(Listar("FIDE_DISTRITOS_POR_CANTON_SP", "P_ID_CANTON", $id));
    }
?>