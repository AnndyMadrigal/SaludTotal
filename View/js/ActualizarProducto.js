$(function () {

    $("#formActualizarProducto").validate({
        rules: {
            Nombre: {
                required: true
            },
            Descripcion: {
                required: true
            },
            Precio: {
               required: true,
               number: true,
               min: 0.01
            },
            Cantidad:{
               required: true,
            },
            ImagenProducto: {
                extension: "png",
                filesize: 2 * 1024 * 1024
            }
        },
        messages: {
            Nombre: {
                required: "* Requerido"
            },
            Descripcion: {
                required: "* Requerido"
            },
            Precio: {
                required: "* Requerido",
                number: "* Solo números válidos.",
                min: "* Debe ser mayor que 0."
            },
            Cantidad:{
               required: "* Requerido",
            },
            ImagenProducto: {
                extension: "* Solo se permiten formatos PNG.",
                filesize: "* No debe superar los 2 MB."
            }
        }
    });

    $.validator.addMethod("filesize", function(value, element, param) {
        if (element.files.length === 0) {
            return true; // No obligatorio
        }
        return element.files[0].size <= param;
    }, "El archivo no debe superar los 2 MB.");

    $.validator.addMethod("extension", function(value, element, param) {
        if (value === "") return true; // no obligatorio
        var extension = value.split('.').pop().toLowerCase();
        var allowed = param.split('|');
        return allowed.includes(extension);
    }, "Formato de archivo no permitido.");

});