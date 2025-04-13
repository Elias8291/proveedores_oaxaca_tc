<div class="form-section" id="form-step-1">
    <h4><i class="fas fa-building"></i> Datos Generales</h4>
    <div class="form-group horizontal-group">
        <div class="half-width">
            <label class="form-label data-label">Tipo de Proveedor</label>
            <span id="tipo_proveedor_display" class="data-field">Cargando...</span>
        </div>
        <div class="half-width">
            <label class="form-label data-label">RFC</label>
            <span id="rfc_display" class="data-field">Cargando...</span>
        </div>
    </div>

    <div class="form-group horizontal-group">
        <div class="half-width custom-select">
            <label class="form-label" for="sector">Sector al que Pertenece *</label>
            <select id="sector" name="sector" class="form-control" required>
                <option value="">Seleccione un sector</option>
            </select>
            <p class="formulario__input-error">Debes seleccionar un sector.</p>
        </div>
        <div class="half-width">
            <label class="form-label" for="actividad_comercial">Actividades Comerciales *</label>
            <select id="actividad_comercial" name="actividad_comercial" class="form-control" required disabled>
                <option value="">Primero seleccione un sector</option>
            </select>
            <p class="formulario__input-error">Debes seleccionar al menos una actividad comercial.</p>
        </div>
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
        <label class="form-label data-label">CURP (Solo si es persona física)</label>
        <span id="curp_display" class="data-field">Cargando...</span>
        <p class="form-loading-message">Cargando datos del solicitante...</p>
    </div>

    <div class="form-group horizontal-group">
        <div class="half-width">
            <label class="form-label" for="contacto_telefono">Teléfono de Contacto *</label>
            <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control" placeholder="Ej: (951) 145 45 25" required>
            <p class="formulario__input-error">El teléfono debe contener entre 7 y 14 números.</p>
        </div>
        <div class="half-width">
            <label class="form-label" for="contacto_web">Página Web</label>
            <input type="url" id="contacto_web" name="contacto_web" class="form-control scroll-input" placeholder="Ej: https://www.empresa.com">
            <p class="formulario__input-error">La URL no es válida.</p>
        </div>
    </div>

    <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
    <div class="form-group">
        <label class="form-label" for="contacto_nombre">Nombre Completo *</label>
        <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control" placeholder="Ej: Juan Pérez González" required>
        <p class="formulario__input-error">El nombre debe contener solo letras y espacios.</p>
    </div>
    <div class="form-group">
        <label class="form-label" for="contacto_cargo">Cargo o Puesto *</label>
        <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control" placeholder="Ej: Director General" required>
        <p class="formulario__input-error">Este campo es obligatorio.</p>
    </div>
    <div class="form-group">
        <label class="form-label" for="contacto_correo">Correo Electrónico *</label>
        <input type="email" id="contacto_correo" name="contacto_correo" class="form-control" placeholder="Ej: contacto@empresa.com" required>
        <p class="formulario__input-error">El correo electrónico no es válido.</p>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load solicitante data
            function cargarDatosSolicitante() {
                $.ajax({
                    url: '/api/solicitante-data',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.form-loading-message').show();
                    },
                    success: function(data) {
                        // Display tipo_persona
                        if (data.tipo_persona) {
                            $('#tipo_proveedor_display').text(data.tipo_persona);
                            // Show/hide CURP based on tipo_persona
                            if (data.tipo_persona.toLowerCase() === 'física') {
                                $('#grupo_curp').show();
                            } else {
                                $('#grupo_curp').hide();
                            }
                        } else {
                            $('#tipo_proveedor_display').text('No disponible');
                        }

                        // Display CURP
                        if (data.curp) {
                            $('#curp_display').text(data.curp);
                        } else {
                            $('#curp_display').text('No aplica');
                        }

                        // Display RFC
                        if (data.rfc) {
                            $('#rfc_display').text(data.rfc);
                        } else {
                            $('#rfc_display').text('No disponible');
                        }

                        // Populate other fields (editable)
                        if (data.email) {
                            $('#contacto_correo').val(data.email);
                        }
                        if (data.razon_social) {
                            $('#contacto_nombre').val(data.razon_social);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar datos del solicitante:', error);
                        $('#tipo_proveedor_display').text('Error al cargar');
                        $('#curp_display').text('Error al cargar');
                        $('#rfc_display').text('Error al cargar');
                    },
                    complete: function() {
                        $('.form-loading-message').hide();
                    }
                });
            }

            // Call on page load
            cargarDatosSolicitante();

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
</body>