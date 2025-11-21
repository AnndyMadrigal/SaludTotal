<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/UsuarioController.php';
  
  $listaRoles = ConsultarRolesSistema(); 
  
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
                            <h4 class="card-header">Agregar Nuevo Usuario</h4>
                            <div class="card-body">
                                
                                <form action="../../Controller/UsuarioController.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre de Usuario</label>
                                        <input type="text" class="form-control" name="NombreUsuario" required />
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" name="Contrasenna" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Rol del Sistema</label>
                                        <select class="form-select" name="IDRol" required>
                                            <option value="">Seleccione un Rol</option>
                                            <?php foreach($listaRoles as $rol): ?>
                                                <option value="<?= $rol['id_rol_sistema'] ?>">
                                                    <?= htmlspecialchars($rol['nombre_rol']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">ID Personal (Opcional)</label>
                                            <input type="number" class="form-control" name="IDPersonal" placeholder="Ej: ID de un médico" />
                                            <div class="form-text">Llenar solo si el usuario es empleado.</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">ID Paciente (Opcional)</label>
                                            <input type="number" class="form-control" name="IDPaciente" placeholder="Ej: ID de un paciente" />
                                            <div class="form-text">Llenar solo si el usuario es paciente.</div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Usuarios.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnAgregarUsuario" type="submit">Guardar Usuario</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <?php ShowFooter(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php ShowJS(); ?>
</body>
</html>