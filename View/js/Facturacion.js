$(document).ready(function() {
    let contadorFilas = 0;

    // 1. FUNCION AGREGAR FILA
    $('#btnAgregarLinea').click(function() {
        contadorFilas++;
        let html = `
        <tr id="fila_${contadorFilas}">
            <td>
                <select class="form-select tipo-selector" data-id="${contadorFilas}" name="detalles[${contadorFilas}][tipo]" required>
                    <option value="">Seleccione...</option>
                    <option value="1">Servicio</option>
                    <option value="2">Medicamento</option>
                </select>
            </td>
            <td>
                <select class="form-select item-selector" data-id="${contadorFilas}" name="detalles[${contadorFilas}][id_item]" disabled required>
                    <option value="">-- Seleccione Tipo --</option>
                </select>
                <input type="hidden" name="detalles[${contadorFilas}][concepto]" class="concepto-hidden">
            </td>
            <td>
                <input type="number" class="form-control cantidad-input" data-id="${contadorFilas}" name="detalles[${contadorFilas}][cantidad]" value="1" min="1" required>
            </td>
            <td>
                <input type="text" class="form-control precio-visual" id="precio_${contadorFilas}" readonly>
            </td>
            <td>
                <input type="text" class="form-control subtotal-visual" id="subtotal_${contadorFilas}" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="${contadorFilas}"><i class="fa fa-trash"></i></button>
            </td>
        </tr>`;
        
        $('#tbodyDetalles').append(html);
    });

    // 2. FUNCION ELIMINAR FILA
    $(document).on('click', '.btn-eliminar', function() {
        let id = $(this).data('id');
        $('#fila_' + id).remove();
        calcularTotales();
    });

    // 3. CAMBIO DE TIPO (ESTA ES LA PARTE QUE FALTABA)
    $(document).on('change', '.tipo-selector', function() {
        let idFila = $(this).data('id');
        let tipo = $(this).val();
        let $comboItems = $(`#fila_${idFila} .item-selector`);
        
        // Limpiar combo
        $comboItems.empty().append('<option value="">Seleccione...</option>');
        
        // Llenar desde los DIVs ocultos de PHP
        if(tipo == '1') { // Servicio
            $comboItems.append($('#listaServicios').html());
            $comboItems.prop('disabled', false); // Habilitar
        } else if (tipo == '2') { // Medicamento
            $comboItems.append($('#listaMedicamentos').html());
            $comboItems.prop('disabled', false); // Habilitar
        } else {
            $comboItems.prop('disabled', true); // Deshabilitar si no hay selección
        }
        
        // Resetear precio
        $(`#precio_${idFila}`).val('');
        $(`#subtotal_${idFila}`).val('');
        calcularTotales();
    });

    // 4. CAMBIO DE ITEM (BUSCAR PRECIO API)
    $(document).on('change', '.item-selector', function() {
        let idFila = $(this).data('id');
        let idItem = $(this).val();
        let tipo = $(`#fila_${idFila} .tipo-selector`).val();
        
        // Guardar nombre del concepto (opcional)
        let concepto = $(this).find("option:selected").text();
        $(`#fila_${idFila} .concepto-hidden`).val(concepto);

        if(idItem) {
            $.getJSON('../../Controller/FacturacionPreciosController.php', { action: 'getPrecio', tipo: tipo, id: idItem }, function(data) {
                $(`#precio_${idFila}`).val(data.precio);
                calcularLinea(idFila);
            });
        }
    });

    // 5. CAMBIO DE CANTIDAD
    $(document).on('input', '.cantidad-input', function() {
        let idFila = $(this).data('id');
        calcularLinea(idFila);
    });

    // FUNCIONES AUXILIARES DE CALCULO VISUAL
    function calcularLinea(id) {
        let cant = parseFloat($(`input[name="detalles[${id}][cantidad]"]`).val()) || 0;
        let precio = parseFloat($(`#precio_${id}`).val()) || 0;
        let sub = cant * precio;
        
        $(`#subtotal_${id}`).val(sub.toFixed(2));
        calcularTotales();
    }

    function calcularTotales() {
        let subtotal = 0;
        $('.subtotal-visual').each(function() {
            subtotal += parseFloat($(this).val()) || 0;
        });

        let iva = subtotal * 0.13;
        let total = subtotal + iva;

        $('#txtSubtotalGeneral').val(subtotal.toFixed(2));
        $('#txtIVA').val(iva.toFixed(2));
        $('#txtTotal').val(total.toFixed(2));
    }
});