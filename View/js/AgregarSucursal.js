$(function () {

    $("#formAgregarSucursal").validate({
        rules: {
            Nombre: {
                required: true
            },
            Telefono: {
                required: true
            },
            IDDireccion: {
               required: true,
               number: true,
               min: 0.01
            }
        },
        messages: {
            Nombre: {
                required: "* Requerido"
            },
            Telefono: {
                required: "* Requerido"
            },
            IDDireccion: {
                required: "* Requerido"
            }
        }
    });
});