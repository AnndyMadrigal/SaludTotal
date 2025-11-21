<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/UsuarioController.php';

  $id = $_GET["id"];
  $datosUsuario = ConsultarUsuario($id); //Datos del usuario actual
  
  //CARGAMOS LAS LISTAS DESDE LA BD
  $listaRoles = ConsultarRolesSistema(); 
  $listaEstados = ConsultarEstados();

  if(!$datosUsuario) {
      header("Location: Usuarios.php");
      exit;
  }
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
                            <h4 class="card-header">Actualizar Usuario</h4>
                            <div class="card-body">
                                
                                <form id="formActualizarUsuario"action="../../Controller/UsuarioController.php" method="POST">
                                    <input type="hidden" name="IDUsuario" value="<?= $datosUsuario['id_usuario'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre de Usuario (No editable)</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($datosUsuario['nombre_usuario']) ?>" readonly disabled />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Rol del Sistema</label>
                                        <select class="form-select" name="IDRol">
                                            <option value="">Seleccione un rol</option>
                                            <?php foreach($listaRoles as $rol): ?>
                                                <option value="<?= $rol['id_rol_sistema'] ?>" 
                                                    <?= ($rol['id_rol_sistema'] == $datosUsuario['id_rol_sistema']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($rol['nombre_rol']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-select" name="IDEstado">
                                            <option value="">Seleccione un estado</option>
                                            <?php foreach($listaEstados as $estado): ?>
                                                <option value="<?= $estado['id_estado'] ?>" 
                                                    <?= ($estado['id_estado'] == $datosUsuario['id_estado']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($estado['nombre_estado']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="Usuarios.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                                        <button class="btn btn-primary" name="btnActualizarUsuario" type="submit">Actualizar</button>
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