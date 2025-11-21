<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/UsuarioController.php';

  $resultado = ConsultarUsuarios();
?>

<!DOCTYPE html>
<html lang="en">
<?php ShowCSS(); ?>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php ShowMenu(); ?>
            <div class="layout-page">
                <?php ShowNav(); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="card mb-4 mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                <h4 class="card-header mb-0 text-center flex-grow-1">Gestión de Usuarios</h4>
                                <a class="btn btn-outline-primary position-absolute end-0 me-3" href="AgregarUsuario.php">Agregar</a>
                            </div>

                            <div class="card-body">
                                <table id="tUsuarios" class="table table-hover mb-4">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Rol Sistema</th>
                                            <th>ID Personal</th>
                                            <th>ID Paciente</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resultado as $fila): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($fila['nombre_usuario']) ?></td>
                                            <td>
                                                <?php 
                                                    $roles = [1=>'Admin', 2=>'Médico', 3=>'Recepción', 4=>'Paciente'];
                                                    echo isset($roles[$fila['id_rol_sistema']]) ? $roles[$fila['id_rol_sistema']] : $fila['id_rol_sistema'];
                                                ?>
                                            </td>
                                            <td><?= $fila['id_personal'] ?></td>
                                            <td><?= $fila['id_paciente'] ?></td>
                                            <td>
                                                <?php if($fila['id_estado'] == 1): ?>
                                                    <span class="badge bg-label-success">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-label-danger">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div style="display:flex; align-items:center; gap:10px;">
                                                    <a href="ActualizarUsuario.php?id=<?= $fila['id_usuario'] ?>">
                                                        <i class="fa fa-edit" style="font-size:22px;"></i>
                                                    </a>

                                                    <form method="POST" action="../../Controller/UsuarioController.php" style="margin:0;">
                                                        <input type="hidden" name="IDUsuario" value="<?= $fila['id_usuario'] ?>">
                                                        <input type="hidden" name="EstadoActual" value="<?= $fila['id_estado'] ?>">
                                                        <button type="submit" name="btnCambiarEstado" style="background:none; border:none; color:#0d6efd; cursor:pointer;">
                                                            <i class="fa fa-refresh" style="font-size:22px;"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <?php ShowFooter(); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <?php ShowJS(); ?>
    <script src="../js/VerUsuarios.js"></script>
    
</body>
</html>