$(function () {

    $("#formActualizarSucursal").validate({
        rules: {
            Nombre: {
                required: true
            },
            IDDireccion: {
               required: true,
            },
            Telefono:{
               required: true,
            }
        },
        messages: {
            Nombre: {
                required: "* Requerido"
            },
            IDDireccion: {
                required: "* Requerido"
            },
            Telefono: {
                required: "* Requerido",
            },
        }
    });
});