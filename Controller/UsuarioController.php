<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Model/UsuarioModel.php';

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    function ConsultarUsuarios()
    {
        return ConsultarUsuariosModel();
    }

    function ConsultarUsuario($id)
    {
        return ConsultarUsuarioModel($id);
    }

    //AGREGAR USUARIO
    if(isset($_POST["btnAgregarUsuario"]))
    {
        $nombreUsuario = $_POST["NombreUsuario"];
        $contrasenna = $_POST["Contrasenna"];
        $idRol = $_POST["IDRol"];
        
        // Un usuario es Personal O Paciente, no ambos (generalmente)
        $idPersonal = $_POST["IDPersonal"];
        $idPaciente = $_POST["IDPaciente"];

        $resultado = AgregarUsuarioModel($nombreUsuario, $contrasenna, $idPersonal, $idPaciente, $idRol);

        if($resultado)
        {
            header("Location: ../View/Usuarios/Usuarios.php");
            exit;
        }
        else
        {
            header("Location: ../View/Usuarios/Usuarios.php?error=1");
            exit;
        }        
    }

    //ACTUALIZAR USUARIO
    if(isset($_POST["btnActualizarUsuario"]))
    {
        $idUsuario = $_POST["IDUsuario"];
        $idRol = $_POST["IDRol"];
        $idEstado = $_POST["IDEstado"];

        $resultado = ActualizarUsuarioModel($idUsuario, $idRol, $idEstado);

        if($resultado)
        {
            header("Location: ../View/Usuarios/Usuarios.php");
            exit;
        }
        else
        {
            header("Location: ../View/Usuarios/Usuarios.php?error=1");
            exit;
        }        
    }

    // CAMBIAR ESTADO
    if(isset($_POST["btnCambiarEstado"]))
    {
        $idUsuario = $_POST["IDUsuario"];
        $estadoActual = $_POST["EstadoActual"];
        $nuevoEstado = ($estadoActual == 1) ? 2 : 1; 

        $resultado = CambiarEstadoUsuarioModel($idUsuario, $nuevoEstado);

        if($resultado)
        {
            header("Location: ../View/Usuarios/Usuarios.php");
            exit;
        }
    }   

    function ConsultarRolesSistema()
    {
        return ConsultarRolesSistemaModel();
    }

    function ConsultarEstados()
    {
        return ConsultarEstadosModel();
    }

?>