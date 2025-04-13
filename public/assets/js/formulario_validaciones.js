


document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formulario1');
    if (!formulario) return;

    const inputs = document.querySelectorAll('#formulario1 input, #formulario1 select');
    const expresiones = {
        nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
        telefono: /^\d{10}$/,
        web: /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/,
        cargo: /^.{1,50}$/
    };

    const limites = {
        contacto_nombre: 40,
        contacto_telefono: 10,
        contacto_telefono_2: 10,
        contacto_web: 100,
        contacto_cargo: 50
    };

    const campos = {
        contacto_nombre: false,
        contacto_telefono: false,
        contacto_telefono_2: false,
        contacto_correo: false,
        contacto_web: true,
        contacto_cargo: false,
        sector: false,
        actividades_comerciales: false
    };

    const validarCampo = (expresion, input, campo) => {
        const grupo = input.closest('.form-group');
        if (!grupo) return;
        const error = grupo.querySelector('.formulario__input-error');
        if (expresion.test(input.value)) {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            error.classList.remove('formulario__input-error-activo');
            campos[campo] = true;
        } else {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            error.classList.add('formulario__input-error-activo');
            campos[campo] = false;
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
            campos[campo] = true;
        } else {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            error.classList.add('formulario__input-error-activo');
            campos[campo] = false;
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

    const validarActividades = () => {
        const actividadesInput = document.getElementById('actividades_comerciales_input');
        const grupo = document.querySelector('.actividades-contenedor');
        const error = grupo?.querySelector('.formulario__input-error');
        if (actividadesInput && grupo && error) {
            if (actividadesInput.value) {
                grupo.classList.remove('formulario__grupo-incorrecto');
                grupo.classList.add('formulario__grupo-correcto');
                error.classList.remove('formulario__input-error-activo');
                campos['actividades_comerciales'] = true;
            } else {
                grupo.classList.add('formulario__grupo-incorrecto');
                grupo.classList.remove('formulario__grupo-correcto');
                error.classList.add('formulario__input-error-activo');
                campos['actividades_comerciales'] = false;
            }
        }
    };

    inputs.forEach(input => {
        if (input.type !== 'hidden') {
            input.addEventListener('keyup', validarFormulario);
            input.addEventListener('blur', validarFormulario);
            input.addEventListener('change', validarFormulario);
            input.addEventListener('input', validarFormulario);
        }
    });

    document.addEventListener('click', e => {
        if (e.target.closest('.remove-actividad')) validarActividades();
    });

    const actividadComercial = document.getElementById('actividad_comercial');
    if (actividadComercial) actividadComercial.addEventListener('change', () => setTimeout(validarActividades, 0));
});