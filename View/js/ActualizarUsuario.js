$(function () {

    $("#formActualizarUsuario").validate({
        rules: {
            IDRol: {
               required: true,
            },
            IDEstado:{
               required: true,
            }
        },
        messages: {
            IDRol: {
                required: "* Requerido"
            },
            IDEstado: {
                required: "* Requerido"
            }
        }
    });
});