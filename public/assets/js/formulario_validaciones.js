document.addEventListener('DOMContentLoaded', () => {
    // Inicializar formularios
    const formulario1 = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');
    const formulario3 = document.getElementById('formulario3');
    if (!formulario1 && !formulario2 && !formulario3) return;

    // Seleccionar todos los inputs
    const inputs = document.querySelectorAll(
        '#formulario1 input, #formulario1 select, ' +
        '#formulario2 input, #formulario2 select, ' +
        '#formulario3 input, #formulario3 select'
    );

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
        numero_notario: 10,
        numero_registro: 10
    };

    // Estado de los campos
    window.campos = {
        sectores: false,
        actividad: false,
        contacto_telefono: false,
        contacto_web: true,
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
        fecha_inscripcion: false
    };

    // Funciones de validación
    const validarCampo = (expresion, input, campo) => {
        const grupo = input.closest('.form-group') || input.closest('.formulario__grupo');
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

    // Validación de formularios
    const validarFormulario = e => {
        const input = e.target;
        const isRequired = input.hasAttribute('required');

        switch (input.name) {
            // Formulario 1
            case 'sectores':
                validarCampoSimple(input.value !== '', input, 'sectores');
                break;
            case 'actividad':
                validarCampoSimple(input.value !== '', input, 'actividad');
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
                // Validate that a non-empty option is selected
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
        }
    };

    // Asignar eventos a todos los inputs
    inputs.forEach(input => {
        if (input.type !== 'hidden') {
            input.addEventListener('keyup', validarFormulario);
            input.addEventListener('blur', validarFormulario);
            input.addEventListener('change', validarFormulario);
            input.addEventListener('input', validarFormulario);

            // Filtros de caracteres
            if (
                input.name === 'contacto_nombre' ||
                input.name === 'contacto_cargo' ||
                input.name === 'nombre_notario'
            ) {
                input.addEventListener('keydown', e => filtrarCaracteres(e, 'soloLetras'));
            } else if (
                input.name === 'contacto_telefono' ||
                input.name === 'contacto_telefono_2' ||
                input.name === 'numero_escritura' ||
                input.name === 'numero_notario' ||
                input.name === 'numero_registro'
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

   
});