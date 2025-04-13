<form id="formulario1">
    <div class="form-section" id="form-step-1">
        <h4><i class="fas fa-building"></i> Datos Generales</h4>
        <div class="form-group horizontal-group">
            <div class="half-width">
                <label class="form-label data-label">Tipo de Proveedor</label>
                <span class="data-field">{{ Auth::user()->solicitante->tipo_persona ?? 'No disponible' }}</span>
            </div>
            <div class="half-width">
                <label class="form-label data-label">RFC</label>
                <span class="data-field">{{ Auth::user()->rfc ?? 'No disponible' }}</span>
            </div>
        </div>
        <div class="form-group full-width" id="formulario__grupo--sectores">
            <label class="form-label">Sectores</label>
            <select name="sectores" id="sectores" class="form-control">
                <option value="">Seleccione un sector</option>
                @foreach ($sectores as $sector)
                    <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                @endforeach
            </select>
            <p class="formulario__input-error">Debe seleccionar al menos un sector.</p>
        </div>
        <div class="form-group full-width" id="formulario__grupo--actividades">
            <label class="form-label">Actividades</label>
            <select name="actividad" id="actividad" class="form-control" required>
                <option value="">Seleccione una actividad</option>
            </select>
            <p class="formulario__input-error">Debe seleccionar al menos una actividad.</p>
        </div>
        <div class="form-group full-width" id="actividades-seleccionadas-container">
            <label class="form-label">Actividades Seleccionadas</label>
            <div id="actividades-seleccionadas" class="actividades-container">
                <!-- Hardcoded activity removed -->
            </div>
        </div>
        @if (Auth::user()->solicitante && Auth::user()->solicitante->tipo_persona == 'Física')
            <div class="form-group">
                <label class="form-label data-label">CURP</label>
                <span class="data-field">{{ Auth::user()->solicitante->curp ?? 'No disponible' }}</span>
            </div>
        @endif
        <div class="horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--contacto_telefono">
                <label class="form-label" for="contacto_telefono">Teléfono de Contacto</label>
                <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control">
                <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos numéricos.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--contacto_web">
                <label class="form-label" for="contacto_web">Página Web</label>
                <input type="url" id="contacto_web" name="contacto_web" class="form-control" placeholder="https://www.empresa.com">
                <p class="formulario__input-error">La URL debe ser válida (ej. https://www.empresa.com) o dejar en blanco.</p>
            </div>
        </div>
        <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
        <span>Persona encargada de recibir solicitudes y requerimientos</span>
        <div class="form-group" id="formulario__grupo--contacto_nombre">
            <label class="form-label" for="contacto_nombre">Nombre Completo</label>
            <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control" value="{{ Auth::user()->solicitante->razon_social ?? '' }}">
            <p class="formulario__input-error">El nombre debe contener solo letras y espacios, máximo 40 caracteres.</p>
        </div>
        <div class="form-group" id="formulario__grupo--contacto_cargo">
            <label class="form-label" for="contacto_cargo">Cargo o Puesto</label>
            <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control">
            <p class="formulario__input-error">El cargo debe contener solo letras y espacios, máximo 50 caracteres.</p>
        </div>
        <div class="form-group" id="formulario__grupo--contacto_correo">
            <label class="form-label" for="contacto_correo">Correo Electrónico</label>
            <input type="email" id="contacto_correo" name="contacto_correo" class="form-control" value="{{ Auth::user()->solicitante->email ?? '' }}">
            <p class="formulario__input-error">El correo debe tener un formato válido (ej. usuario@dominio.com).</p>
        </div>
        <div class="form-group" id="formulario__grupo--contacto_telefono_2">
            <label class="form-label" for="contacto_telefono_2">Teléfono de Contacto 2</label>
            <input type="tel" id="contacto_telefono_2" name="contacto_telefono_2" class="form-control">
            <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos numéricos.</p>
        </div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sectorSelect = document.getElementById('sectores');
    const actividadSelect = document.getElementById('actividad');
    const actividadesContainer = document.getElementById('actividades-seleccionadas');
    const actividadesSeleccionadas = new Set();
    let actividadesDisponibles = []; // Almacenaremos todas las actividades del sector

    // Evento cuando cambia el sector
    sectorSelect.addEventListener('change', function() {
        const sectorId = this.value;
        
        if (sectorId) {
            // Limpiar actividades anteriores
            actividadSelect.innerHTML = '<option value="">Seleccione una actividad</option>';
            actividadesDisponibles = [];
            
            // Hacer petición AJAX para obtener las actividades del sector seleccionado
            fetch(`/sectores/${sectorId}/actividades`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        actividadesDisponibles = data.data; // Guardamos todas las actividades
                        updateActividadesDropdown(); // Actualizamos el dropdown
                    }
                })
                .catch(error => {
                    console.error('Error al cargar actividades:', error);
                });
        } else {
            actividadSelect.innerHTML = '<option value="">Seleccione un sector primero</option>';
            actividadesDisponibles = [];
        }
    });

    // Función para actualizar las opciones del dropdown de actividades
    function updateActividadesDropdown() {
        // Limpiar el select
        actividadSelect.innerHTML = '<option value="">Seleccione una actividad</option>';
        
        // Agregar solo las actividades que no estén seleccionadas
        actividadesDisponibles.forEach(actividad => {
            if (!actividadesSeleccionadas.has(actividad.id.toString())) {
                const option = document.createElement('option');
                option.value = actividad.id;
                option.textContent = actividad.nombre;
                actividadSelect.appendChild(option);
            }
        });
    }

    // Evento cuando se selecciona una actividad
    actividadSelect.addEventListener('change', function() {
        const selectedValue = actividadSelect.value;
        const selectedText = actividadSelect.options[actividadSelect.selectedIndex].text;

        if (selectedValue && !actividadesSeleccionadas.has(selectedValue)) {
            actividadesSeleccionadas.add(selectedValue);

            const actividadItem = document.createElement('div');
            actividadItem.classList.add('actividad-item');
            actividadItem.dataset.value = selectedValue;
            actividadItem.innerHTML = `
                <span class="actividad-texto">${selectedText}</span>
                <span class="remove-actividad">×</span>
            `;
            actividadesContainer.appendChild(actividadItem);

            // Evento para eliminar actividad
            actividadItem.querySelector('.remove-actividad').addEventListener('click', function() {
                actividadesSeleccionadas.delete(selectedValue);
                actividadItem.remove();
                validateActividades();
                updateActividadesDropdown(); // Actualizar el dropdown cuando se elimina una actividad
            });

            // Resetear el select y actualizar opciones
            actividadSelect.value = '';
            updateActividadesDropdown();
        }

        validateActividades();
    });

    // Validación de actividades
    function validateActividades() {
        const errorElement = document.querySelector(
            '#formulario__grupo--actividades .formulario__input-error');
        if (actividadesSeleccionadas.size === 0) {
            errorElement.style.display = 'block';
        } else {
            errorElement.style.display = 'none';
        }
    }

    // Validar al enviar el formulario
    document.getElementById('formulario1').addEventListener('submit', function(e) {
        if (actividadesSeleccionadas.size === 0) {
            e.preventDefault();
            validateActividades();
            alert('Debe seleccionar al menos una actividad.');
        }
    });
});
</script>
