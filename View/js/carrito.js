$(document).ready(function() {
        
        //1.CAMBIO DE TIPO (SERIVICIO/MEDICAMENTO)
        $('#cboTipo').change(function() {
            let tipo = $(this).val();
            let combo = $('#cboItem');
            combo.empty().prop('disabled', true);
            
            if(tipo === "") return;

            //llamada AJAX para llenar items según tipo
            $.getJSON('../../Controller/FacturacionPreciosController.php', { action: 'listarItems', tipo: tipo }, function(data) {
                combo.append('<option value="">Seleccione...</option>');
                $.each(data, function(i, item) {
                    combo.append(`<option value="${item.id}">${item.nombre}</option>`);
                });
                combo.prop('disabled', false);
            });
        });

        // 2.AGREGAR AL CARRITO
        window.agregarAlCarrito = function() {
            $.post('../../Controller/FacturacionController.php', $('#formAgregar').serialize(), function(res) {
                location.reload();
            });
        }

        //3.ELIMINAR DEL CARRITO
        window.eliminarDelCarrito = function(id) {
            if(confirm('¿Eliminar item?')) {
                $.post('../../Controller/FacturacionController.php', { action: 'eliminar', id_carrito: id }, function(res) {
                    location.reload();
                });
            }
        }
    });