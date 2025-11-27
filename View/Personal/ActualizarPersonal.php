<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/PersonalController.php';
  
  $p = ConsultarPersonalPorID($_GET["id"]);
  $roles = ConsultarRolesPersonal();
  $sucursales = ConsultarSucursalesLista();
  if(!$p) header("Location: Personal.php");
?>
<!DOCTYPE html> <html lang="en"> <?php ShowCSS(); ?> <body>
<div class="layout-wrapper layout-content-navbar"> <div class="layout-container"> <?php ShowMenu(); ?> <div class="layout-page"> <?php ShowNav(); ?>
<div class="content-wrapper"> <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4 mt-4"> <h4 class="card-header">Editar Personal</h4> <div class="card-body">
        <form action="../../Controller/PersonalController.php" method="POST">
            <input type="hidden" name="IDPersonal" value="<?= $p['id_personal'] ?>">
            <div class="row">
                <div class="col-md-4 mb-3"><label>Nombre</label><input type="text" class="form-control" name="Nombre" value="<?= $p['nombre'] ?>" required></div>
                <div class="col-md-4 mb-3"><label>Apellido Paterno</label><input type="text" class="form-control" name="ApellidoP" value="<?= $p['apellido_paterno'] ?>" required></div>
                <div class="col-md-4 mb-3"><label>Apellido Materno</label><input type="text" class="form-control" name="ApellidoM" value="<?= $p['apellido_materno'] ?>" required></div>
            </div>
            <div class="mb-3"><label>Rol</label>
                <select class="form-select" name="IDRol">
                    <?php foreach($roles as $r) echo "<option value='".$r['id_rol_personal']."' ".($r['id_rol_personal']==$p['id_rol_personal']?'selected':'').">".$r['nombre_rol']."</option>"; ?>
                </select>
            </div>
            <div class="mb-3"><label>Sucursal</label>
                <select class="form-select" name="IDSucursal">
                    <?php foreach($sucursales as $s) echo "<option value='".$s['id_sucursal']."' ".($s['id_sucursal']==$p['id_sucursal']?'selected':'').">".$s['nombre']."</option>"; ?>
                </select>
            </div>
            <button class="btn btn-primary" name="btnActualizarPersonal" type="submit">Actualizar</button>
            <a href="Personal.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div></div>
</div> <?php ShowFooter(); ?> </div> </div> </div> </div> <?php ShowJS(); ?> </body> </html>