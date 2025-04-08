<div class="form-section" id="form-step-1">
    <div class="form-container">
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-building"></i> Datos Generales</h4>
            </div>
            <div class="form-group custom-select">
                <label class="form-label" for="tipo_proveedor">Tipo de Proveedor *</label>
                <select id="tipo_proveedor" name="tipo_proveedor" class="form-control" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="fisica">Persona Física</option>
                    <option value="moral">Persona Moral</option>
                </select>
                <p class="formulario__input-error">Debes seleccionar un tipo de proveedor.</p>
            </div>
            <div class="form-group custom-select">
                <label class="form-label" for="sector">Sector al que Pertenece *</label>
                <select id="sector" name="sector" class="form-control" required>
                    <option value="">Seleccione un sector</option>
                </select>
                <p class="formulario__input-error">Debes seleccionar un sector.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="actividad_comercial">Actividades Comerciales (Puede seleccionar una o
                    varias) *</label>
                <select id="actividad_comercial" name="actividad_comercial" class="form-control" required disabled>
                    <option value="">Primero seleccione un sector</option>
                </select>
                <p class="formulario__input-error">Debes seleccionar al menos una actividad comercial.</p>
            </div>
            <div class="form-group full-width actividades-contenedor">
                <div class="actividades-header">
                    <i class="fas fa-list-check"></i> Actividades Seleccionadas
                </div>
                <div id="actividades_seleccionadas" class="actividades-lista">
                    <div class="empty-message">No hay actividades seleccionadas</div>
                </div>
                <input type="hidden" name="actividades_comerciales" id="actividades_comerciales_input">
            </div>
            <div class="form-group" id="grupo_curp">
                <label class="form-label" for="curp">CURP (Solo si es persona física)</label>
                <input type="text" id="curp" name="curp" class="form-control"
                    placeholder="Ej: ABCD123456HDFXYZ01" maxlength="18">
                <p class="formulario__input-error">El CURP no tiene un formato válido.</p>
            </div>
            <div class="form-group" id="grupo_rfc">
                <label class="form-label" for="rfc">RFC *</label>
                <input type="text" id="rfc" name="rfc" class="form-control" placeholder="Ej: XAXX010101000"
                    required>
                <p class="formulario__input-error">El RFC no tiene un formato válido.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_telefono">Teléfono de Contacto *</label>
                <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control"
                    placeholder="Ej: (951) 145 45 25" required>
                <p class="formulario__input-error">El teléfono debe contener entre 7 y 14 números.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_web">Página Web</label>
                <input type="url" id="contacto_web" name="contacto_web" class="form-control"
                    placeholder="Ej: https://www.empresa.com">
                <p class="formulario__input-error">La URL no es válida.</p>
            </div>
        </div>
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_nombre">Nombre Completo *</label>
                <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control"
                    placeholder="Ej: Juan Pérez González" required>
                <p class="formulario__input-error">El nombre debe contener solo letras y espacios.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_cargo">Cargo o Puesto *</label>
                <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control"
                    placeholder="Ej: Director General" required>
                <p class="formulario__input-error">Este campo es obligatorio.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_telefono">Teléfono de Contacto *</label>
                <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control"
                    placeholder="Ej: (951) 145 45 25" required>
                <p class="formulario__input-error">El teléfono debe contener entre 7 y 14 números.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_correo">Correo Electrónico *</label>
                <input type="email" id="contacto_correo" name="contacto_correo" class="form-control"
                    placeholder="Ej: contacto@empresa.com" required>
                <p class="formulario__input-error">El correo electrónico no es válido.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tipo_proveedor').change(function() {
            if ($(this).val() === 'fisica') {
                $('#grupo_curp').show();
            } else {
                $('#grupo_curp').hide();
                $('#curp').val('');
            }
        }).trigger('change');

        cargarSectores();

        $('#sector').change(function() {
            const sectorId = $(this).val();
            $('#actividades_seleccionadas').empty().html(
                '<div class="empty-message">No hay actividades seleccionadas</div>');
            $('#actividades_comerciales_input').val('');
            if (sectorId) {
                cargarActividades(sectorId);
            } else {
                $('#actividad_comercial').prop('disabled', true).html(
                    '<option value="">Primero seleccione un sector</option>');
            }
        });

        $('#actividad_comercial').change(function() {
            const actividadId = $(this).val();
            const actividadNombre = $(this).find('option:selected').text();
            if (actividadId && !$('#actividad_' + actividadId).length) {
                agregarActividadSeleccionada(actividadId, actividadNombre);
                $(this).val('');
            }
        });

        $(document).on('click', '.remove-actividad', function() {
            $(this).parent().remove();
            actualizarActividadesInput();
            if ($('#actividades_seleccionadas').children().length === 0) {
                $('#actividades_seleccionadas').html(
                    '<div class="empty-message">No hay actividades seleccionadas</div>');
            }
        });

        function cargarSectores() {
            $.ajax({
                url: '/api/sectores',
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#sector').prop('disabled', true);
                },
                success: function(data) {
                    $('#sector').empty().append('<option value="">Seleccione un sector</option>');
                    $.each(data, function(index, sector) {
                        $('#sector').append($('<option>', {
                            value: sector.id,
                            text: sector.nombre
                        }));
                    });
                    $('#sector').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar sectores:', error);
                    $('#sector').prop('disabled', false);
                }
            });
        }

        function cargarActividades(sectorId) {
            $.ajax({
                url: '/api/sectores/' + sectorId + '/actividades',
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#actividad_comercial').prop('disabled', true).html(
                        '<option value="">Cargando actividades...</option>');
                },
                success: function(data) {
                    $('#actividad_comercial').empty().append(
                        '<option value="">Seleccione una actividad</option>');
                    $.each(data, function(index, actividad) {
                        $('#actividad_comercial').append($('<option>', {
                            value: actividad.id,
                            text: actividad.nombre
                        }));
                    });
                    $('#actividad_comercial').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar actividades:', error);
                    $('#actividad_comercial').prop('disabled', false).html(
                        '<option value="">Error al cargar actividades</option>');
                }
            });
        }

        function agregarActividadSeleccionada(id, nombre) {
            if ($('#actividades_seleccionadas .empty-message').length) {
                $('#actividades_seleccionadas').empty();
            }
            $('#actividades_seleccionadas').append(
                `<div class="actividad-item" id="actividad_${id}"><span>${nombre}</span><button type="button" class="remove-actividad" data-id="${id}"><i class="fas fa-times"></i></button><input type="hidden" name="actividades[]" value="${id}"></div>`
                );
            actualizarActividadesInput();
        }

        function actualizarActividadesInput() {
            const actividades = [];
            $('input[name="actividades[]"]').each(function() {
                actividades.push($(this).val());
            });
            $('#actividades_comerciales_input').val(actividades.join(','));
        }
    });
</script>

<style>
    .actividades-contenedor {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        margin-top: 10px;
    }

    .actividades-header {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .actividades-lista {
        min-height: 50px;
    }

    .actividad-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px;
        border-bottom: 1px solid #eee;
    }

    .remove-actividad {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 0 5px;
    }

    .empty-message {
        color: #6c757d;
        font-style: italic;
    }

    .formulario__input-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    .custom-select {
        position: relative;
    }

    .custom-select select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 15px;
    }
</style>
