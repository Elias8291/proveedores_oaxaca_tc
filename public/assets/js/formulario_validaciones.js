document.addEventListener('DOMContentLoaded', () => {
    // Inicializar formularios
    const formulario1 = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');
    const formulario3 = document.getElementById('formulario3');
    const formulario5 = document.getElementById('formulario5');
    const formulario6 = document.getElementById('formulario6');
    if (!formulario1 && !formulario2 && !formulario3 && !formulario5 && !formulario6) return;

    // Seleccionar todos los inputs
    const inputs = document.querySelectorAll(
        '#formulario1 input, #formulario1 select, ' +
        '#formulario2 input, #formulario2 select, ' +
        '#formulario3 input, #formulario3 select, ' +
        '#formulario5 input, #formulario5 select, ' +
        '#formulario6 input, #formulario6 select'
    );

    // Determinar el tipo de persona
    const esPersonaFisica = document.getElementById('acta_nacimiento') || document.getElementById('curp');
    const esPersonaMoral = document.getElementById('acta_constitutiva') || document.getElementById('modificaciones_acta') || document.getElementById('poder_notariado');

    // Expresiones regulares
    const expresiones = {
        contacto_nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        contacto_cargo: /^[a-zA-ZÀ-ÿ\s]{1,50}$/,
        contacto_telefono: /^\d{10}$/,
        contacto_correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
        contacto_web: /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$|^$/,
        calle: /^[a-zA-Z0-9À-ÿ\s]{1,100}$/,
        numero_exterior: /^[a-zA-Z0-9]{1,10}$/,
        numero_interior: /^[a-zA-Z0-9]{0,10}$/,
        entre_calle: /^[a-zA-Z0-9À-ÿ\s]{0,100}$/,
        numero_escritura: /^\d{1,10}$/,
        nombre_notario: /^[a-zA-ZÀ-ÿ\s]{1,100}$/,
        nombre_apoderado: /^[a-zA-ZÀ-ÿ\s]{1,100}$/,
        numero_notario: /^\d{1,10}$/,
        numero_registro: /^\d{1,10}$/
    };

    // Límites de caracteres
    const limites = {
        contacto_nombre: 40,
        contacto_cargo: 50,
        contacto_telefono: 10,
        contacto_web: 100,
        calle: 100,
        numero_exterior: 10,
        numero_interior: 10,
        entre_calle: 100,
        numero_escritura: 10,
        nombre_notario: 100,
        nombre_apoderado: 100,
        numero_notario: 10,
        numero_registro: 10
    };

    // Estado de los campos
    window.campos = {
        sectores: false,
        actividad: true,
        contacto_telefono: false,
        contacto_web: false,
        contacto_nombre: false,
        contacto_cargo: false,
        contacto_correo: false,
        contacto_telefono_2: true,
        codigo_postal: false,
        colonia: false,
        calle: false,
        numero_exterior: false,
        numero_interior: true,
        entre_calle_1: true,
        entre_calle_2: true,
        numero_escritura: false,
        nombre_notario: false,
        entidad_federativa: false,
        fecha_constitucion: false,
        numero_notario: false,
        numero_registro: false,
        fecha_inscripcion: false,
        nombre_apoderado: false,
        fecha_escritura: false,
        constancia_situacion_fiscal: false,
        identificacion_oficial: false,
        curriculum: false,
        comprobante_domicilio: false,
        croquis_fotografias: false,
        carta_poder: true,
        acuse_recibo: false,
        acta_nacimiento: esPersonaFisica ? false : true,
        curp: esPersonaFisica ? false : true,
        acta_constitutiva: esPersonaMoral ? false : true,
        modificaciones_acta: esPersonaMoral ? true : true,
        poder_notariado: esPersonaMoral ? false : true
    };

    // Definir campos por sección
    const camposSeccion = {
        1: ['sectores', 'contacto_nombre', 'contacto_cargo', 'contacto_telefono', 'contacto_correo', 'contacto_web', 'contacto_telefono_2'],
        2: ['codigo_postal', 'colonia', 'calle', 'numero_exterior', 'numero_interior', 'entre_calle_1', 'entre_calle_2'],
        3: ['numero_escritura', 'nombre_notario', 'entidad_federativa', 'fecha_constitucion', 'numero_notario', 'numero_registro', 'fecha_inscripcion'],
        4: [],
        5: ['nombre_apoderado', 'numero_escritura', 'nombre_notario', 'entidad_federativa', 'fecha_escritura', 'numero_notario', 'numero_registro', 'fecha_inscripcion'],
        6: ['constancia_situacion_fiscal', 'identificacion_oficial', 'curriculum', 'comprobante_domicilio', 'croquis_fotografias', 'carta_poder', 'acuse_recibo', 'acta_nacimiento', 'curp', 'acta_constitutiva', 'modificaciones_acta', 'poder_notariado'],
        7: []
    };

    // Validar sección completa
    const validarSeccion = (seccionId) => {
        const campos = camposSeccion[seccionId] || [];
        let isValid = true;
        campos.forEach(campo => {
            if (!window.campos[campo]) {
                isValid = false;
                const input = document.querySelector(`[name="${campo}"]`);
                if (input) {
                    input.dispatchEvent(new Event('change'));
                    input.dispatchEvent(new Event('blur'));
                }
            }
        });
        return isValid;
    };

    // Funciones de validación
    const validarCampo = (expresion, input, campo) => {
        const grupo = input.closest('.form-group') || input.closest('.formulario__grupo');
        if (!grupo) return;
        const error = grupo.querySelector('.formulario__input-error');
    
        // Caso especial para contacto_web
        if (campo === 'contacto_web' && input.value.trim() === '') {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto'); // No marcar como correcto
            error.classList.remove('formulario__input-error-activo');
            window.campos[campo] = true; // Permitir que el formulario pase si está vacío (opcional)
            return;
        }
    
        // Validación normal para otros casos
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
        const grupo = input.closest('.form-group') || input.closest('.formulario__grupo');
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
        } else if (tipo === 'letrasNumeros') {
            if (!/^[a-zA-Z0-9À-ÿ\s]$/.test(tecla)) {
                e.preventDefault();
            }
        }
    };

    // Validación de archivos
    const validarArchivo = (input, campo) => {
        const grupo = input.closest('.formulario__grupo');
        if (!grupo) return;
        const error = grupo.querySelector('.formulario__input-error');
        const errorSize = grupo.querySelector('.formulario__input-error-size');
        const status = grupo.querySelector('.file-status');
        const statusIcon = status.querySelector('.status-icon');
        const statusText = status.querySelector('.status-text');
        const preview = grupo.querySelector('.file-preview');

        input.dataset.touched = 'true';

        error.classList.remove('formulario__input-error-activo');
        if (errorSize) errorSize.classList.remove('formulario__input-error-activo');

        let esRequerido = input.hasAttribute('required');
        if (campo === 'acta_nacimiento' || campo === 'curp') {
            esRequerido = esPersonaFisica;
        } else if (campo === 'acta_constitutiva' || campo === 'poder_notariado') {
            esRequerido = esPersonaMoral;
        } else if (campo === 'modificaciones_acta') {
            esRequerido = false;
        }

        if (input.files.length === 0 && esRequerido) {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            if (input.dataset.touched) {
                error.classList.add('formulario__input-error-activo');
            }
            status.setAttribute('data-status', 'pending');
            statusIcon.innerHTML = '<i class="fas fa-clock"></i>';
            statusText.textContent = 'Pendiente';
            preview.style.display = 'none';
            window.campos[campo] = false;
            return;
        }

        if (input.files.length === 0 && !esRequerido) {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            error.classList.remove('formulario__input-error-activo');
            if (errorSize) errorSize.classList.remove('formulario__input-error-activo');
            status.setAttribute('data-status', 'optional');
            statusIcon.innerHTML = '<i class="fas fa-check"></i>';
            statusText.textContent = 'Opcional';
            preview.style.display = 'none';
            window.campos[campo] = true;
            return;
        }

        const archivo = input.files[0];
        const maxSize = 10 * 1024 * 1024;
        const esPDF = archivo.type === 'application/pdf';

        if (esPDF && archivo.size <= maxSize) {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            error.classList.remove('formulario__input-error-activo');
            if (errorSize) errorSize.classList.remove('formulario__input-error-activo');
            status.setAttribute('data-status', 'completed');
            statusIcon.innerHTML = '<i class="fas fa-check"></i>';
            statusText.textContent = 'Completado';
            preview.style.display = 'block';
            window.campos[campo] = true;
        } else {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            if (esPDF) {
                if (errorSize) errorSize.classList.add('formulario__input-error-activo');
                error.classList.remove('formulario__input-error-activo');
            } else {
                error.classList.add('formulario__input-error-activo');
                if (errorSize) errorSize.classList.remove('formulario__input-error-activo');
            }
            status.setAttribute('data-status', 'error');
            statusIcon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            statusText.textContent = 'Error';
            preview.style.display = 'none';
            window.campos[campo] = false;
        }
    };

    // Validación de formularios
    const validarFormulario = e => {
        const input = e.target;
        const isRequired = input.hasAttribute('required');

        switch (input.name) {
            // Formulario 1
            case 'sectores':
                validarCampoSimple(input.value !== '', input, 'sectores');
                break;
            case 'contacto_telefono':
                limitarCaracteres(input, limites.contacto_telefono);
                validarCampo(expresiones.contacto_telefono, input, 'contacto_telefono');
                break;
            case 'contacto_web':
                limitarCaracteres(input, limites.contacto_web);
                validarCampo(expresiones.contacto_web, input, 'contacto_web');
                break;
            case 'contacto_nombre':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.contacto_nombre);
                validarCampo(expresiones.contacto_nombre, input, 'contacto_nombre');
                break;
            case 'contacto_cargo':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.contacto_cargo);
                validarCampo(expresiones.contacto_cargo, input, 'contacto_cargo');
                break;
            case 'contacto_correo':
                validarCampo(expresiones.contacto_correo, input, 'contacto_correo');
                break;
            case 'contacto_telefono_2':
                limitarCaracteres(input, limites.contacto_telefono);
                validarCampo(expresiones.contacto_telefono, input, 'contacto_telefono_2');
                break;

            // Formulario 2
            case 'colonia':
                validarCampoSimple(input.value !== '', input, 'colonia');
                break;
            case 'calle':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.calle);
                validarCampo(expresiones.calle, input, 'calle');
                break;
            case 'numero_exterior':
                limitarCaracteres(input, limites.numero_exterior);
                validarCampo(expresiones.numero_exterior, input, 'numero_exterior');
                break;
            case 'numero_interior':
                limitarCaracteres(input, limites.numero_interior);
                if (input.value === '' || expresiones.numero_interior.test(input.value)) {
                    const grupo = input.closest('.form-group');
                    if (grupo) {
                        grupo.classList.remove('formulario__grupo-incorrecto');
                        grupo.classList.add('formulario__grupo-correcto');
                        const error = grupo.querySelector('.formulario__input-error');
                        if (error) error.classList.remove('formulario__input-error-activo');
                        window.campos.numero_interior = true;
                    }
                } else {
                    const grupo = input.closest('.form-group');
                    if (grupo) {
                        grupo.classList.add('formulario__grupo-incorrecto');
                        grupo.classList.remove('formulario__grupo-correcto');
                        const error = grupo.querySelector('.formulario__input-error');
                        if (error) error.classList.add('formulario__input-error-activo');
                        window.campos.numero_interior = false;
                    }
                }
                break;
            case 'entre_calle_1':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.entre_calle);
                validarCampo(expresiones.entre_calle, input, 'entre_calle_1');
                break;
            case 'entre_calle_2':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.entre_calle);
                validarCampo(expresiones.entre_calle, input, 'entre_calle_2');
                break;

            // Formulario 3
            case 'numero_escritura':
                limitarCaracteres(input, limites.numero_escritura);
                validarCampo(expresiones.numero_escritura, input, 'numero_escritura');
                break;
            case 'nombre_notario':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.nombre_notario);
                validarCampo(expresiones.nombre_notario, input, 'nombre_notario');
                break;
            case 'entidad_federativa':
                validarCampoSimple(input.value !== '', input, 'entidad_federativa');
                break;
            case 'fecha_constitucion':
                validarCampoSimple(input.value !== '', input, 'fecha_constitucion');
                break;
            case 'numero_notario':
                limitarCaracteres(input, limites.numero_notario);
                validarCampo(expresiones.numero_notario, input, 'numero_notario');
                break;
            case 'numero_registro':
                limitarCaracteres(input, limites.numero_registro);
                validarCampo(expresiones.numero_registro, input, 'numero_registro');
                break;
            case 'fecha_inscripcion':
                validarCampoSimple(input.value !== '', input, 'fecha_inscripcion');
                break;

            // Formulario 5
            case 'nombre-apoderado':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.nombre_apoderado);
                validarCampo(expresiones.nombre_apoderado, input, 'nombre_apoderado');
                break;
            case 'numero-escritura':
                limitarCaracteres(input, limites.numero_escritura);
                validarCampo(expresiones.numero_escritura, input, 'numero_escritura');
                break;
            case 'nombre-notario':
                convertirMayusculas(input);
                limitarCaracteres(input, limites.nombre_notario);
                validarCampo(expresiones.nombre_notario, input, 'nombre_notario');
                break;
            case 'numero-notario':
                limitarCaracteres(input, limites.numero_notario);
                validarCampo(expresiones.numero_notario, input, 'numero_notario');
                break;
            case 'entidad-federativa':
                validarCampoSimple(input.value !== '', input, 'entidad_federativa');
                break;
            case 'fecha-escritura':
                validarCampoSimple(input.value !== '', input, 'fecha_escritura');
                break;
            case 'numero-registro':
                limitarCaracteres(input, limites.numero_registro);
                validarCampo(expresiones.numero_registro, input, 'numero_registro');
                break;
            case 'fecha-inscripcion':
                validarCampoSimple(input.value !== '', input, 'fecha_inscripcion');
                break;

            // Formulario 6
            case 'constancia_situacion_fiscal':
                validarArchivo(input, 'constancia_situacion_fiscal');
                break;
            case 'identificacion_oficial':
                validarArchivo(input, 'identificacion_oficial');
                break;
            case 'curriculum':
                validarArchivo(input, 'curriculum');
                break;
            case 'comprobante_domicilio':
                validarArchivo(input, 'comprobante_domicilio');
                break;
            case 'croquis_fotografias':
                validarArchivo(input, 'croquis_fotografias');
                break;
            case 'carta_poder':
                validarArchivo(input, 'carta_poder');
                break;
            case 'acuse_recibo':
                validarArchivo(input, 'acuse_recibo');
                break;
            case 'acta_nacimiento':
                validarArchivo(input, 'acta_nacimiento');
                break;
            case 'curp':
                validarArchivo(input, 'curp');
                break;
            case 'acta_constitutiva':
                validarArchivo(input, 'acta_constitutiva');
                break;
            case 'modificaciones_acta':
                validarArchivo(input, 'modificaciones_acta');
                break;
            case 'poder_notariado':
                validarArchivo(input, 'poder_notariado');
                break;
        }
    };

    // Asignar eventos a todos los inputs
    inputs.forEach(input => {
        if (input.type !== 'hidden' && input.name !== 'actividad') {
            if (input.type === 'file') {
                input.addEventListener('change', validarFormulario);
                input.addEventListener('blur', () => {
                    if (!input.dataset.touched) {
                        input.dataset.touched = 'true';
                        validarFormulario({ target: input });
                    }
                });
            } else {
                input.addEventListener('keyup', validarFormulario);
                input.addEventListener('blur', validarFormulario);
                input.addEventListener('change', validarFormulario);
                input.addEventListener('input', validarFormulario);
            }

            if (
                input.name === 'contacto_nombre' ||
                input.name === 'contacto_cargo' ||
                input.name === 'nombre_notario' ||
                input.name === 'nombre-apoderado'
            ) {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'soloLetras'));
            } else if (
                input.name === 'contacto_telefono' ||
                input.name === 'contacto_telefono_2' ||
                input.name === 'numero_escritura' ||
                input.name === 'numero-notario' ||
                input.name === 'numero-registro' ||
                input.name === 'numero-escritura'
            ) {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'soloNumeros'));
            } else if (
                input.name === 'calle' ||
                input.name === 'entre_calle_1' ||
                input.name === 'entre_calle_2' ||
                input.name === 'numero_exterior' ||
                input.name === 'numero_interior'
            ) {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'letrasNumeros'));
            }
        }
    });

    // Manejar el evento de submit para cada formulario
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const seccionId = parseInt(form.id.replace('formulario', ''));
            if (validarSeccion(seccionId)) {
                window.formNavigation.goToNextSection();
            }
        });
    });
});