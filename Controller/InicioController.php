<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/UtilesController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/InicioModel.php';

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(isset($_POST["btnCrearCuenta"]))
    {
        $identificacion = $_POST["Identificacion"];
        $nombre = $_POST["Nombre"];
        $correoElectronico = $_POST["CorreoElectronico"];
        $contrasenna = $_POST["Contrasenna"];

        $resultado = CrearCuentaModel($identificacion,$nombre,$correoElectronico,$contrasenna);

        if($resultado)
        {
            header("Location: ../../View/Inicio/IniciarSesion.php");
            exit;
        }

        $_POST["Mensaje"] = "No se ha podido crear la cuenta solicitada";
    }

    // Lógica de Iniciar Sesión
    if(isset($_POST["btnIniciarSesion"]))
    {
        $usuario = $_POST["NombreUsuario"]; 
        $contrasenna = $_POST["Contrasenna"];

        // Llamamos al modelo
        $datosUsuario = ValidarCuentaModel($usuario, $contrasenna);

        if($datosUsuario != null)
        {
            // Guardamos datos en Sesión según tus columnas de Oracle
            $_SESSION["IdUsuario"] = $datosUsuario["ID_USUARIO"];
            $_SESSION["NombreUsuario"] = $datosUsuario["NOMBRE_USUARIO"];
            $_SESSION["IdRol"] = $datosUsuario["ID_ROL_SISTEMA"];
            
            // Opcional: Guardar ID personal o paciente si existen
            $_SESSION["IdPersonal"] = $datosUsuario["ID_PERSONAL"]; 
            $_SESSION["IdPaciente"] = $datosUsuario["ID_PACIENTE"];

            // Redirección
            header("Location: ../../View/Inicio/Principal.php");
            exit;
        }
        else 
        {
            $_POST["Mensaje"] = "Usuario o contraseña incorrectos, o la cuenta está inactiva.";
        }
    }


    if(isset($_POST["btnSalir"]))
    {
        session_destroy();
        header("Location: ../../View/Inicio/IniciarSesion.php");
        exit;
    }

    function ConsultarIndicadores()
    {
        return ConsultarIndicadoresModel();
    }
    

?>