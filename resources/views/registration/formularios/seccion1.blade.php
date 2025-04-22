<form id="formulario1">
    <!-- Sección para subir Constancia de Situación Fiscal, visible solo para revisor_1 -->
    @if (Auth::user()->hasRole('revisor_1'))
        <div class="form-section" id="constancia-upload-section">
            <h4><i class="fas fa-file-pdf"></i> Subir Constancia de Situación Fiscal</h4>
            <div class="form-group full-width" id="formulario__grupo--constancia">
                <label class="form-label" for="constancia_upload">Seleccionar Constancia de Situación Fiscal (PDF)</label>
                <input type="file" id="constancia_upload" name="constancia_upload" class="form-control"
                    accept="application/pdf" required>
                <p class="formulario__input-error">Debe seleccionar un archivo en formato PDF.</p>
            </div>
        </div>
    @endif

    <!-- Resto del formulario -->
    <div class="form-section" id="form-step-1">
        <h4><i class="fas fa-building"></i> Datos Generales</h4>
        <div class="form-group horizontal-group">
            <div class="half-width">
                <label class="form-label data-label">Tipo de Proveedor</label>
                @if (Auth::user()->hasRole('solicitante'))
                    <span class="data-field">{{ Auth::user()->solicitante->tipo_persona ?? 'No disponible' }}</span>
                    @else
                    <select name="tipo_persona" id="tipo_persona" class="form-control" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="Física">Física</option>
                        <option value="Moral">Moral</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar 'Física' o 'Moral'.</p>
                @endif
            </div>
            <div class="half-width">
                <label class="form-label data-label">RFC</label>
                @if (Auth::user()->hasRole('solicitante'))
                    <span class="data-field">{{ Auth::user()->rfc ?? 'No disponible' }}</span>
                @else
                    <input type="text" name="rfc" id="rfc" class="form-control"
                        placeholder="Ej. XAXX010101000" required maxlength="13" pattern="[A-Z0-9]{12,13}">
                    <p class="formulario__input-error">El RFC debe tener 12 o 13 caracteres alfanuméricos.</p>
                @endif
            </div>
        </div>
        <!-- Campos visibles solo para revisor_1 -->
        @if (Auth::user()->hasRole('revisor_1'))
            <div class="form-group horizontal-group">
                <div class="half-width form-group" id="formulario__grupo--razon_social">
                    <label class="form-label" for="razon_social">Razón Social</label>
                    <input type="text" id="razon_social" name="razon_social" class="form-control" required
                        maxlength="100" pattern="[A-Za-z\s&.,0-9]+">
                    <p class="formulario__input-error">La razón social debe contener solo letras, números, espacios y
                        caracteres (&,.,).</p>
                </div>
                <div class="half-width form-group" id="formulario__grupo--correo_electronico">
                    <label class="form-label" for="correo_electronico">Correo Electrónico</label>
                    <input type="email" id="correo_electronico" name="correo_electronico" class="form-control"
                        required>
                    <p class="formulario__input-error">El correo debe tener un formato válido (ej. usuario@dominio.com).
                    </p>
                </div>
            </div>
        @endif
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
                <!-- Actividades seleccionadas se añadirán aquí dinámicamente -->
            </div>
        </div>
        @if (Auth::user()->hasRole('solicitante') &&
                Auth::user()->solicitante &&
                Auth::user()->solicitante->tipo_persona == 'Física')
            <div class="form-group">
                <label class="form-label data-label">CURP</label>
                <span class="data-field">{{ Auth::user()->solicitante->curp ?? 'No disponible' }}</span>
            </div>
        @endif
        <div class="horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--contacto_telefono">
                <label class="form-label" for="contacto_telefono">Teléfono de Contacto</label>
                <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control" required
                    pattern="[0-9]{10}">
                <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos numéricos.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--contacto_web">
                <label class="form-label" for="contacto_web">Página Web (opcional)</label>
                <input type="url" id="contacto_web" name="contacto_web" class="form-control"
                    placeholder="https://www.ejemplo.com">
                <p class="formulario__input-error">La URL debe ser válida (ej. https://www.empresa.com) o dejar en
                    blanco.</p>
            </div>
        </div>
        <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
        <span>Persona encargada de recibir solicitudes y requerimientos</span>
        <div class="form-group" id="formulario__grupo--contacto_nombre">
            <label class="form-label" for="contacto_nombre">Nombre Completo</label>
            <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control" required
                maxlength="40" pattern="[A-Za-z\s]+">
            <p class="formulario__input-error">El nombre debe contener solo letras y espacios, máximo 40 caracteres.
            </p>
        </div>
        <div class="form-group" id="formulario__grupo--contacto_cargo">
            <label class="form-label" for="contacto_cargo">Cargo o Puesto</label>
            <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control" required
                maxlength="50" pattern="[A-Za-z\s]+">
            <p class="formulario__input-error">El cargo debe contener solo letras y espacios, máximo 50 caracteres.</p>
        </div>
        <div class="form-group" id="formulario__grupo--contacto_correo">
            <label class="form-label" for="contacto_correo">Correo Electrónico</label>
            <input type="email" id="contacto_correo" name="contacto_correo" class="form-control" required>
            <p class="formulario__input-error">El correo debe tener un formato válido (ej. usuario@dominio.com).</p>
        </div>
        <div class="form-group" id="formulario__grupo--contacto_telefono_2">
            <label class="form-label" for="contacto_telefono_2">Teléfono de Contacto 2</label>
            <input type="tel" id="contacto_telefono_2" name="contacto_telefono_2" class="form-control" required
                pattern="[0-9]{10}">
            <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos numéricos.</p>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación para el campo de subida de Constancia de Situación Fiscal
        const constanciaInput = document.getElementById('constancia_upload');
        if (constanciaInput) {
            constanciaInput.addEventListener('change', async function() {
                const file = this.files[0];
                const errorElement = document.querySelector(
                    '#formulario__grupo--constancia .formulario__input-error');

                if (!file) {
                    errorElement.style.display = 'block';
                    return;
                }

                if (file.type !== 'application/pdf') {
                    errorElement.style.display = 'block';
                    this.value = ''; // Limpiar archivo inválido
                    return;
                }

                errorElement.style.display = 'none';

                // Process the PDF and scrape SAT data
                try {
                    const loading = createModal({
                        html: createSpinner()
                    });
                    const pdfData = await extractQRCodeFromPDF(file);
                    const satData = await scrapeSATData(pdfData.qrUrl);
                    document.body.removeChild(loading);

                    // Autocomplete form fields
                    autocompleteFormFields(pdfData, satData);
                } catch (error) {
                    document.body.removeChild(loading);
                    showError(`Error al procesar el PDF: ${error.message}`);
                    this.value = ''; // Clear invalid file
                }
            });
        }

        // Función para autocompletar los campos del formulario
        function autocompleteFormFields(pdfData, satData) {
            const isRevisor = !!document.getElementById('constancia_upload'); // Check if user is revisor_1
            const nombre = pdfData.tipo === 'Moral' ? satData.razonSocial || pdfData.name : satData
                .nombreCompleto || pdfData.name;

            // Map of form field IDs to their corresponding values
            const fieldMappings = {
                tipo_persona: pdfData.tipo || '',
                rfc: pdfData.rfc || '',
                contacto_correo: satData.email?.toUpperCase() || '',
                contacto_nombre: nombre?.toUpperCase() || '',
            };

            // Populate form fields
            Object.entries(fieldMappings).forEach(([fieldId, value]) => {
                const element = document.getElementById(fieldId);
                if (element && isRevisor && element.tagName === 'INPUT') {
                    element.value = value;
                }
            });

            // Handle CURP for Persona Física
            if (pdfData.tipo === 'Física' && satData.curp) {
                const curpField = document.querySelector('.data-field[data-field="curp"]');
                if (curpField) {
                    curpField.textContent = satData.curp.toUpperCase() || 'No disponible';
                }
            }
        }

        // Código existente para sectores y actividades
        const sectorSelect = document.getElementById('sectores');
        const actividadSelect = document.getElementById('actividad');
        const actividadesContainer = document.getElementById('actividades-seleccionadas');
        const actividadesSeleccionadas = new Set();
        let actividadesDisponibles = [];
        let actividadesIds = [];

        sectorSelect.addEventListener('change', function() {
            const sectorId = this.value;
            actividadesSeleccionadas.clear();
            actividadesIds = [];
            console.log('Actividades IDs:', actividadesIds);
            actividadesContainer.innerHTML = '';

            if (sectorId) {
                actividadSelect.innerHTML = '<option value="">Seleccione una actividad</option>';
                actividadesDisponibles = [];

                fetch(`/sectores/${sectorId}/actividades`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            actividadesDisponibles = data.data;
                            updateActividadesDropdown();
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar actividades:', error);
                    });
            } else {
                actividadSelect.innerHTML = '<option value="">Seleccione un sector primero</option>';
                actividadesDisponibles = [];
            }

            validateActividades();
        });

        function updateActividadesDropdown() {
            actividadSelect.innerHTML = '<option value="">Seleccione una actividad</option>';
            actividadesDisponibles.forEach(actividad => {
                if (!actividadesSeleccionadas.has(actividad.id.toString())) {
                    const option = document.createElement('option');
                    option.value = actividad.id;
                    option.textContent = actividad.nombre;
                    actividadSelect.appendChild(option);
                }
            });
        }

        actividadSelect.addEventListener('change', function() {
            const selectedValue = actividadSelect.value;
            const selectedText = actividadSelect.options[actividadSelect.selectedIndex].text;

            if (selectedValue && !actividadesSeleccionadas.has(selectedValue)) {
                actividadesSeleccionadas.add(selectedValue);
                actividadesIds.push(selectedValue);
                console.log('Actividades IDs:', actividadesIds);

                const actividadItem = document.createElement('div');
                actividadItem.classList.add('actividad-item');
                actividadItem.dataset.value = selectedValue;
                actividadItem.innerHTML = `
                    <span class="actividad-texto">${selectedText}</span>
                    <span class="remove-actividad">×</span>
                `;
                actividadesContainer.appendChild(actividadItem);

                actividadItem.querySelector('.remove-actividad').addEventListener('click', function() {
                    actividadesSeleccionadas.delete(selectedValue);
                    actividadesIds = actividadesIds.filter(id => id !== selectedValue);
                    console.log('Actividades IDs:', actividadesIds);
                    actividadItem.remove();
                    validateActividades();
                    updateActividadesDropdown();
                });

                actividadSelect.value = '';
                updateActividadesDropdown();
            }

            validateActividades();
        });

        function validateActividades() {
            const errorElement = document.querySelector(
                '#formulario__grupo--actividades .formulario__input-error');
            if (actividadesSeleccionadas.size === 0) {
                errorElement.style.display = 'block';
            } else {
                errorElement.style.display = 'none';
            }
        }
    });
</script>
