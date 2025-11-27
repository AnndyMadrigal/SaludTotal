/**
 * Lógica Genérica para ACTUALIZAR DIRECCIONES
 * Se usa en: ActualizarPaciente.php, ActualizarSucursal.php, etc.
 * Requiere inputs ocultos: #valProvincia, #valCanton, #valDistrito
 */

$(document).ready(function() {
    
    const $cboProvincia = $('#cboProvincia');
    const $cboCanton = $('#cboCanton');
    const $cboDistrito = $('#cboDistrito');

    // Valores guardados en la BD (Inputs Ocultos)
    const savedProvincia = $('#valProvincia').val();
    const savedCanton = $('#valCanton').val();
    const savedDistrito = $('#valDistrito').val();

    const API_URL = '../../Controller/UbicacionController.php';

    //---FUNCIONES AUXILIARES ---

    function cargarProvincias() {
        return $.getJSON(API_URL, { action: 'getProvincias' }, function(data) {
            $cboProvincia.empty().append('<option value="">Seleccione...</option>');
            $.each(data, function(key, val) {
                // Marcar como seleccionado si coincide
                const selected = (val.id_provincia == savedProvincia) ? 'selected' : '';
                $cboProvincia.append(`<option value="${val.id_provincia}" ${selected}>${val.nombre_provincia}</option>`);
            });
        });
    }

    function cargarCantones(provinciaId, preSelectedId) {
        if (!provinciaId) return Promise.resolve();

        return $.getJSON(API_URL, { action: 'getCantones', id: provinciaId }, function(data) {
            $cboCanton.empty().append('<option value="">Seleccione...</option>').prop('disabled', false);
            $.each(data, function(key, val) {
                const selected = (val.id_canton == preSelectedId) ? 'selected' : '';
                $cboCanton.append(`<option value="${val.id_canton}" ${selected}>${val.nombre_canton}</option>`);
            });
        });
    }

    function cargarDistritos(cantonId, preSelectedId) {
        if (!cantonId) return Promise.resolve();

        return $.getJSON(API_URL, { action: 'getDistritos', id: cantonId }, function(data) {
            $cboDistrito.empty().append('<option value="">Seleccione...</option>').prop('disabled', false);
            $.each(data, function(key, val) {
                const selected = (val.id_distrito == preSelectedId) ? 'selected' : '';
                $cboDistrito.append(`<option value="${val.id_distrito}" ${selected}>${val.nombre_distrito}</option>`);
            });
        });
    }

    //---SECUENCIA DE INICIO(PRE-CARGA)---
    
    //1.Cargar Provincias -> 2.Cargar Cantones del guardado -> 3.Cargar Distritos del guardado
    cargarProvincias().then(function() {
        if (savedProvincia) {
            cargarCantones(savedProvincia, savedCanton).then(function() {
                if (savedCanton) {
                    cargarDistritos(savedCanton, savedDistrito);
                }
            });
        }
    });

    // ---EVENTOS MANUALES (Si el usuario cambia algo)---

    $cboProvincia.change(function() {
        const id = $(this).val();
        $cboCanton.empty().append('<option value="">Cargando...</option>').prop('disabled', true);
        $cboDistrito.empty().append('<option value="">Seleccione cantón primero</option>').prop('disabled', true);
        
        cargarCantones(id, null); //null porque es cambio manual
    });

    $cboCanton.change(function() {
        const id = $(this).val();
        $cboDistrito.empty().append('<option value="">Cargando...</option>').prop('disabled', true);
        
        cargarDistritos(id, null);
    });
});