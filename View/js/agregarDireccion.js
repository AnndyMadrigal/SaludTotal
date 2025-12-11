/**
 * Lógica para AGREGAR DIRECCIONES
 * Se usa en: AgregarPaciente.php, AgregarSucursal.php
 */

$(document).ready(function() {
    
    console.log("Cargando script agregarDireccion.js...");

    // Referencias a los elementos del DOM
    const $cboProvincia = $('#cboProvincia');
    const $cboCanton = $('#cboCanton');
    const $cboDistrito = $('#cboDistrito');

    // Ruta al API
    const API_URL = '../../Controller/UbicacionController.php';

    // 1. Cargar Provincias al iniciar
    $.getJSON(API_URL, { action: 'getProvincias' }, function(data) {
        console.log("Provincias cargadas:", data); // Debug
        
        $cboProvincia.empty().append('<option value="">Seleccione...</option>');
        
        $.each(data, function(key, val) {
            // Usamos nombres en minúscula como vienen de UtilesModel
            $cboProvincia.append(`<option value="${val.id_provincia}">${val.nombre_provincia}</option>`);
        });
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar provincias:", textStatus, errorThrown);
    });

    // 2. Al cambiar Provincia -> Cargar Cantones
    $cboProvincia.change(function() {
        const id = $(this).val();
        
        // Resetear dependientes
        $cboCanton.empty().append('<option value="">Seleccione provincia primero</option>').prop('disabled', true);
        $cboDistrito.empty().append('<option value="">Seleccione cantón primero</option>').prop('disabled', true);
        
        if(id) {
            $.getJSON(API_URL, { action: 'getCantones', id: id }, function(data) {
                $cboCanton.empty().append('<option value="">Seleccione...</option>').prop('disabled', false);
                $.each(data, function(key, val) {
                    $cboCanton.append(`<option value="${val.id_canton}">${val.nombre_canton}</option>`);
                });
            });
        }
    });

    // 3. Al cambiar Cantón -> Cargar Distritos
    $cboCanton.change(function() {
        const id = $(this).val();
        
        // Resetear dependiente
        $cboDistrito.empty().append('<option value="">Seleccione cantón primero</option>').prop('disabled', true);
        
        if(id) {
            $.getJSON(API_URL, { action: 'getDistritos', id: id }, function(data) {
                $cboDistrito.empty().append('<option value="">Seleccione...</option>').prop('disabled', false);
                $.each(data, function(key, val) {
                    $cboDistrito.append(`<option value="${val.id_distrito}">${val.nombre_distrito}</option>`);
                });
            });
        }
    });
});