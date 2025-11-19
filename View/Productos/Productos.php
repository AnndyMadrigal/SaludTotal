<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/View/LayoutInterno.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/SaludTotal/Controller/ProductoController.php';

  $resultado = ConsultarProductos();
?>

<!DOCTYPE html>
<html lang="en">

<?php
    ShowCSS();
  ?>

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
                                <h4 class="card-header mb-0 text-center flex-grow-1">Productos</h4>
                                <a class="btn btn-outline-primary position-absolute end-0 me-3"
                                    href="AgregarProducto.php">Agregar</a>
                            </div>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="card-body">

                                        <?php
                                            if(isset($_POST["Mensaje"]))
                                            {
                                                echo '<div class="alert alert-primary centrado">' . $_POST["Mensaje"] . '</div>';
                                            }
                                        ?>

                                        <table id="tProductos" class="table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Estado</th>
                                                    <th>Imagen</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($resultado as $fila): ?>
                                                <tr>
                                                    <td><?= $fila['ConsecutivoProducto'] ?></td>
                                                    <td><?= htmlspecialchars($fila['Nombre']) ?></td>
                                                    <td>$<?= number_format($fila['Precio'], 2) ?></td>
                                                    <td><?= $fila['Cantidad'] ?></td>
                                                    <td><?= htmlspecialchars($fila['EstadoDescripcion']) ?></td>
                                                    <td>
                                                        <img src="<?= htmlspecialchars($fila['Imagen']) ?>" width="85"
                                                            height="85" alt="<?= htmlspecialchars($fila['Nombre']) ?>">
                                                    </td>
                                                    <td>
                                                        <div style="display:flex; align-items:center; gap:10px;">
                                                            <!-- Enlace para editar -->
                                                            <a
                                                                href="ActualizarProducto.php?id=<?= $fila['ConsecutivoProducto'] ?>">
                                                                <i class="fa fa-edit" style="font-size:22px;"></i>
                                                            </a>

                                                            <!-- Formulario para cambiar estado -->
                                                            <form method="POST" action=""
                                                                style="margin:0; display:inline;">
                                                                <input type="hidden" name="ConsecutivoProducto"
                                                                    value="<?= $fila['ConsecutivoProducto'] ?>">
                                                                <button type="submit" name="btnCambiarEstado"
                                                                    style="background:none; border:none; color:#0d6efd; cursor:pointer; padding:0;">
                                                                    <i class="fa fa-refresh"
                                                                        style="font-size:22px;"></i>
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
                        </div>

                    </div>

                    <?php ShowFooter(); ?>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <?php
      ShowJS();
    ?>
    <script src="../js/VerProductos.js"></script>

</body>

</html>