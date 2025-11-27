<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/PacienteModel.php';

    function ConsultarPacientes() { return ConsultarPacientesModel(); }
    function ConsultarPacientePorID($id) { return ConsultarPacientePorIDModel($id); }
    function ConsultarDirecciones() { return ConsultarDireccionesModel(); }

    if(isset($_POST["btnAgregarPaciente"])) {
    //1.primero creamos la dirección
    $idDistrito = $_POST["cboDistrito"];
    $detalles = $_POST["DetallesDireccion"];
    
    $idDireccionNueva = CrearDireccionYObtenerID($idDistrito, $detalles);
    
    //2.ahora insertamos al paciente con esa dirección nueva
    $res = AgregarPacienteModel(
        $_POST["Nombre"], 
        $_POST["ApellidoP"], 
        $_POST["ApellidoM"], 
        $_POST["FechaNac"], 
        $idDireccionNueva // <--- Usamos el ID generado
    );

    header("Location: ../View/Pacientes/Pacientes.php" . ($res ? "" : "?error=1"));
    }

    if(isset($_POST["btnActualizarPaciente"])) {
        $res = ActualizarPacienteModel($_POST["IDPaciente"], $_POST["Nombre"], $_POST["ApellidoP"], $_POST["ApellidoM"], $_POST["IDDireccion"]);
        header("Location: ../View/Pacientes/Pacientes.php" . ($res ? "" : "?error=1"));
    }

    if(isset($_POST["btnCambiarEstado"])) {
        $nuevo = ($_POST["EstadoActual"] == 1) ? 2 : 1;
        CambiarEstadoPacienteModel($_POST["IDPaciente"], $nuevo);
        header("Location: ../View/Pacientes/Pacientes.php");
    }

    //exponer la nueva función de consulta
    function ConsultarPacienteFull($id) {
        return ConsultarPacienteFullPorIDModel($id);
    }

    //logica de actualizacion
    if(isset($_POST["btnActualizarPaciente"])) {
        // 1.actualizamos los datos de la Dirección existente
        ActualizarDireccionModel(
            $_POST["IDDireccion"], // ID Oculto en el form
            $_POST["cboDistrito"], 
            $_POST["DetallesDireccion"]
        );
        
        // 2.actualizamos los datos del Paciente
        $res = ActualizarPacienteModel(
            $_POST["IDPaciente"], 
            $_POST["Nombre"], 
            $_POST["ApellidoP"], 
            $_POST["ApellidoM"], 
            $_POST["IDDireccion"] // Mantenemos el mismo ID de dirección
        );
        
        header("Location: ../View/Pacientes/Pacientes.php");
    }
?>