document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formulario1');
    if (!formulario) return;

    const inputs = document.querySelectorAll('#formulario1 input, #formulario1 select');
    const expresiones = {
        nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
        telefono: /^\d{10}$/,
        web: /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/,
        cargo: /^[a-zA-ZÀ-ÿ\s]{1,50}$/
    };

    const limites = {
        contacto_nombre: 40,
        contacto_telefono: 10,
        contacto_telefono_2: 10,
        contacto_web: 100,
        contacto_cargo: 50
    };

    window.campos = {
        contacto_nombre: false,
        contacto_telefono: false,
        contacto_telefono_2: false,
        contacto_correo: false,
        contacto_web: true,
        contacto_cargo: false,
        sector: false,
        actividades_comerciales: false
    };

    // Objeto para almacenar los nombres de las actividades seleccionadas
    let actividadesNombres = {};

   // Update these validation functions in your existing JS file

const validarCampo = (expresion, input, campo) => {
    const grupo = input.closest('.form-group');
    if (!grupo) return;
    const error = grupo.querySelector('.formulario__input-error');
    
    if (expresion.test(input.value)) {
        grupo.classList.remove('formulario__grupo-incorrecto');
        grupo.classList.add('formulario__grupo-correcto');
        error.classList.remove('formulario__input-error-activo');
        window.campos[campo] = true;
    } else {
        grupo.classList.add('formulario__grupo-incorrecto');
        grupo.classList.remove('formulario__grupo-correcto');
        error.classList.add('formulario__input-error-activo');
        window.campos[campo] = false;
    }
};

const validarCampoSimple = (condicion, input, campo) => {
    const grupo = input.closest('.form-group');
    if (!grupo) return;
    const error = grupo.querySelector('.formulario__input-error');
    
    if (condicion) {
        grupo.classList.remove('formulario__grupo-incorrecto');
        grupo.classList.add('formulario__grupo-correcto');
        error.classList.remove('formulario__input-error-activo');
        window.campos[campo] = true;
    } else {
        grupo.classList.add('formulario__grupo-incorrecto');
        grupo.classList.remove('formulario__grupo-correcto');
        error.classList.add('formulario__input-error-activo');
        window.campos[campo] = false;
    }
};

    const limitarCaracteres = (input, max) => {
        if (input.value.length > max) {
            input.value = input.value.slice(0, max);
        }
    };

    const convertirMayusculas = input => {
        input.value = input.value.toUpperCase();
    };

    const filtrarCaracteres = (e, tipo) => {
        const tecla = e.key;
        const esTeclaEspecial = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(tecla);
        if (esTeclaEspecial) return;

        if (tipo === 'soloLetras') {
            if (!/^[a-zA-ZÀ-ÿ\s]$/.test(tecla)) {
                e.preventDefault();
            }
        } else if (tipo === 'soloNumeros') {
            if (!/^\d$/.test(tecla)) {
                e.preventDefault();
            }
        } else if (tipo === 'correo') {
            if (!/^[a-zA-Z0-9_.+-@]$/.test(tecla)) {
                e.preventDefault();
            }
        } else if (tipo === 'web') {
            if (!/^[a-zA-Z0-9.:/\-?=&]$/.test(tecla)) {
                e.preventDefault();
            }
        }
    };

    const validarFormulario = e => {
        const input = e.target;
        switch (input.name) {
            case 'contacto_nombre':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.contacto_nombre);
                validarCampo(expresiones.nombre, input, 'contacto_nombre');
                break;
            case 'contacto_telefono':
                limitarCaracteres(input, limites.contacto_telefono);
                validarCampo(expresiones.telefono, input, 'contacto_telefono');
                break;
            case 'contacto_telefono_2':
                limitarCaracteres(input, limites.contacto_telefono_2);
                validarCampo(expresiones.telefono, input, 'contacto_telefono_2');
                break;
            case 'contacto_correo':
                validarCampo(expresiones.correo, input, 'contacto_correo');
                break;
            case 'contacto_web':
                limitarCaracteres(input, limites.contacto_web);
                input.value === '' ? validarCampoSimple(true, input, 'contacto_web') : validarCampo(expresiones.web, input, 'contacto_web');
                break;
            case 'contacto_cargo':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.contacto_cargo);
                validarCampo(expresiones.cargo, input, 'contacto_cargo');
                break;
            case 'sector':
                validarCampoSimple(input.value !== '', input, 'sector');
                break;
        }
    };

    window.validarActividades = () => {
        const actividadesInput = document.getElementById('actividades_comerciales_input');
        const grupo = document.querySelector('.actividades-contenedor');
        const error = grupo?.querySelector('.formulario__input-error');
        const actividadesSeleccionadas = $('#actividades_seleccionadas .actividad-item').length;

        if (actividadesInput && grupo && error) {
            if (actividadesSeleccionadas > 0 && actividadesInput.value) {
                grupo.classList.remove('formulario__grupo-incorrecto');
                grupo.classList.add('formulario__grupo-correcto');
                error.classList.remove('formulario__input-error-activo');
                window.campos['actividades_comerciales'] = true;
            } else {
                grupo.classList.add('formulario__grupo-incorrecto');
                grupo.classList.remove('formulario__grupo-correcto');
                error.classList.add('formulario__input-error-activo');
                window.campos['actividades_comerciales'] = false;
            }
        }
    };

    // Función para agregar actividad seleccionada
    const agregarActividadSeleccionada = (id, nombre) => {
        if ($('#actividades_seleccionadas .empty-message').length) {
            $('#actividades_seleccionadas').empty();
        }
        $('#actividades_seleccionadas').append(
            `<div class="actividad-item" id="actividad_${id}"><span>${nombre}</span><button type="button" class="remove-actividad" data-id="${id}"><i class="fas fa-times"></i></button><input type="hidden" name="actividades[]" value="${id}"></div>`
        );
        actividadesNombres[id] = nombre; // Almacenar el nombre
        actualizarActividadesInput();
        validarActividades();
    };

    // Función para actualizar el campo oculto
    const actualizarActividadesInput = () => {
        const actividades = [];
        $('input[name="actividades[]"]').each(function() {
            actividades.push($(this).val());
        });
        $('#actividades_comerciales_input').val(actividades.join(','));
    };

    // Función para restaurar actividades seleccionadas
    const restaurarActividades = () => {
        const actividadesGuardadas = $('#actividades_comerciales_input').val();
        if (actividadesGuardadas) {
            const actividadesIds = actividadesGuardadas.split(',');
            $('#actividades_seleccionadas').empty();
            actividadesIds.forEach(id => {
                if (actividadesNombres[id]) {
                    agregarActividadSeleccionada(id, actividadesNombres[id]);
                }
            });
            validarActividades();
        } else {
            $('#actividades_seleccionadas').html(
                '<div class="empty-message">No hay actividades seleccionadas</div>'
            );
        }
    };

    inputs.forEach(input => {
        if (input.type !== 'hidden') {
            input.addEventListener('keyup', validarFormulario);
            input.addEventListener('blur', validarFormulario);
            input.addEventListener('change', validarFormulario);
            input.addEventListener('input', validarFormulario);

            if (input.name === 'contacto_nombre' || input.name === 'contacto_cargo') {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'soloLetras'));
            } else if (input.name === 'contacto_telefono' || input.name === 'contacto_telefono_2') {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'soloNumeros'));
            } else if (input.name === 'contacto_correo') {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'correo'));
            } else if (input.name === 'contacto_web') {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'web'));
            }
        }
    });

    const actividadComercial = document.getElementById('actividad_comercial');
    if (actividadComercial) {
        actividadComercial.addEventListener('change', () => {
            const actividadId = actividadComercial.value;
            const actividadNombre = actividadComercial.options[actividadComercial.selectedIndex].text;
            if (actividadId && !$(`#actividad_${actividadId}`).length) {
                agregarActividadSeleccionada(actividadId, actividadNombre);
                actividadComercial.value = '';
            }
            setTimeout(validarActividades, 0);
        });
    }

    // Restaurar actividades al cargar el formulario
    restaurarActividades();

    // Evento change del sector
    $('#sector').change(function() {
        const sectorId = $(this).val();
        if (sectorId) {
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
        } else {
            $('#actividad_comercial').prop('disabled', true).html(
                '<option value="">Primero seleccione un sector</option>');
        }
        validarCampoSimple(sectorId !== '', this, 'sector');
        validarActividades();
    });

    // Manejo de eliminación de actividades
    $(document).on('click', '.remove-actividad', function() {
        const id = $(this).data('id');
        $(this).parent().remove();
        delete actividadesNombres[id];
        actualizarActividadesInput();
        if ($('#actividades_seleccionadas').children().length === 0) {
            $('#actividades_seleccionadas').html(
                '<div class="empty-message">No hay actividades seleccionadas</div>');
        }
        validarActividades();
    });
});