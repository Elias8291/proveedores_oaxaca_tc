<form id="formulario1">
    <!-- Sección para subir Constancia de Situación Fiscal, visible solo para revisor_1 -->
    @if (Auth::user()->hasRole('revisor_1'))
    <div class="form-section" id="constancia-upload-section">
        <h4><i class="fas fa-file-pdf"></i> Subir Constancia de Situación Fiscal</h4>
        <div class="form-group full-width" id="formulario__grupo--constancia">
            <label class="form-label" for="constancia_upload">
                <span>Seleccionar Constancia de Situación Fiscal</span>
                <span class="file-desc">Formato PDF, máximo 5MB</span>
            </label>
            <input type="file" id="constancia_upload" name="constancia_upload" class="form-control"
                accept="application/pdf" required>
            <p class="formulario__input-error">Debe seleccionar un archivo en formato PDF.</p>
            <!-- Contenedor para confirmación de subida y vista previa -->
            <div class="pdf-preview-container" id="upload-feedback" style="display: none;">
                <i class="fas fa-file-pdf pdf-icon"></i>
                <span class="pdf-name upload-success">PDF subido correctamente</span>
                <button class="view-pdf-btn preview-pdf" id="preview-pdf" title="Ver PDF">
                    <i class="fas fa-eye"></i> Ver PDF
                </button>
            </div>
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
        <!-- CURP field, initially hidden for revisor_1, shown dynamically if tipo_persona is Física -->
        @if (Auth::user()->hasRole('revisor_1') || (Auth::user()->hasRole('solicitante') && Auth::user()->solicitante && Auth::user()->solicitante->tipo_persona == 'Física'))
            <div class="form-group" id="curp-field" style="display: none;">
                <label class="form-label data-label">CURP</label>
                <span class="data-field" id="curp-value">{{ Auth::user()->solicitante->curp ?? 'No disponible' }}</span>
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
    // Función para actualizar la visibilidad de los campos del formulario según tipo_persona
    function updateFormVisibility(tipoPersona) {
        const curpField = document.getElementById('curp-field');
        if (curpField) {
            if (tipoPersona === 'Física') {
                curpField.style.display = 'block';
            } else {
                curpField.style.display = 'none';
            }
        }
    }

    // Función para autocompletar los campos del formulario
    function autocompleteFormFields(pdfData, satData) {
        const isRevisor = !!document.getElementById('constancia_upload');

        const fieldMappings = {
            tipo_persona: pdfData.tipo || '',
            rfc: pdfData.rfc || '',
            razon_social: satData.razonSocial?.toUpperCase() || '',
            correo_electronico: satData.email?.toUpperCase() || ''
        };

        Object.entries(fieldMappings).forEach(([fieldId, value]) => {
            const element = document.getElementById(fieldId);
            if (element && isRevisor) {
                if (element.tagName === 'INPUT') {
                    element.value = value;
                } else if (element.tagName === 'SELECT') {
                    element.value = value;
                }
            }
        });

        if (pdfData.tipo === 'Física' && satData.curp) {
            const curpField = document.querySelector('.data-field#curp-value');
            if (curpField) {
                curpField.textContent = satData.curp.toUpperCase() || 'No disponible';
            }
        }

        // Actualizar visibilidad del formulario y secciones después de autocompletar tipo_persona
        if (pdfData.tipo && isRevisor) {
            updateFormVisibility(pdfData.tipo);
            if (pdfData.tipo === 'Física' || pdfData.tipo === 'Moral') {
                const tipoPersonaSelect = document.getElementById('tipo_persona');
                if (tipoPersonaSelect) {
                    tipoPersonaSelect.value = pdfData.tipo;
                    if (window.formNavigation && window.formNavigation.updateSectionsByTipoPersona) {
                        window.formNavigation.updateSectionsByTipoPersona(pdfData.tipo);
                    }
                    const changeEvent = new Event('change');
                    tipoPersonaSelect.dispatchEvent(changeEvent);
                }
            }
        }
    }

    // Código para sectores y actividades
    const sectorSelect = document.getElementById('sectores');
    const actividadSelect = document.getElementById('actividad');
    const actividadesContainer = document.getElementById('actividades-seleccionadas');
    const actividadesSeleccionadas = new Set();
    let actividadesDisponibles = [];
    let actividadesIds = [];

    if (sectorSelect) {
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
    }

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

    if (actividadSelect) {
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
    }

    function validateActividades() {
        const errorElement = document.querySelector('#formulario__grupo--actividades .formulario__input-error');
        if (errorElement) {
            if (actividadesSeleccionadas.size === 0) {
                errorElement.style.display = 'block';
            } else {
                errorElement.style.display = 'none';
            }
        }
    }

    // Procesar PDF automáticamente al cargarlo
    const fileInput = document.getElementById('constancia_upload');
    const uploadFeedback = document.getElementById('upload-feedback');
    const previewPdfLink = document.getElementById('preview-pdf');
    const formGroupConstancia = document.getElementById('formulario__grupo--constancia');

    if (fileInput) {
    fileInput.addEventListener('change', async function() {
        const file = fileInput.files[0];
        if (!file) {
            console.error('No se seleccionó ningún archivo.');
            uploadFeedback.style.display = 'none';
            return;
        }

        if (file.type !== 'application/pdf') {
            console.error('El archivo debe ser un PDF.');
            uploadFeedback.style.display = 'block';
            uploadFeedback.innerHTML = '<span class="upload-error"><i class="fas fa-exclamation-circle"></i> Debe seleccionar un archivo en formato PDF.</span>';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            console.error('El archivo excede el tamaño máximo de 5MB.');
            uploadFeedback.style.display = 'block';
            uploadFeedback.innerHTML = '<span class="upload-error"><i class="fas fa-exclamation-circle"></i> El archivo excede el tamaño máximo de 5MB.</span>';
            return;
        }

        // Add progress bar
        let progressBar = formGroupConstancia.querySelector('.pdf-upload-progress');
        if (!progressBar) {
            progressBar = document.createElement('div');
            progressBar.classList.add('pdf-upload-progress');
            progressBar.innerHTML = '<div class="progress-bar"></div>';
            formGroupConstancia.appendChild(progressBar);
        }
        progressBar.style.display = 'block';
        const progressBarInner = progressBar.querySelector('.progress-bar');

        // Simulate progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += 10;
            progressBarInner.style.width = `${progress}%`;
            if (progress >= 100) {
                clearInterval(progressInterval);
                progressBar.style.display = 'none';
            }
        }, 100);

        try {
            // Extraer datos del PDF
            const pdfData = await window.extractQRCodeFromPDF(file);
            console.log('Datos extraídos del PDF:', pdfData);

            // Obtener datos del SAT
            const satData = await window.scrapeSATData(pdfData.qrUrl);
            console.log('Datos extraídos del SAT:', satData);

            // Combinar y retornar los datos
            const combinedData = {
                pdfData: pdfData,
                satData: satData
            };
            console.log('Datos combinados:', combinedData);

            // Autocompletar campos del Formulario 1
            autocompleteFormFields(pdfData, satData);

            // Autocompletar campos de dirección en Formulario 2
            populateFormulario2AddressFields(satData);

            // Update UI for successful upload
            formGroupConstancia.classList.add('pdf-upload-success');
            uploadFeedback.style.display = 'block';
            uploadFeedback.innerHTML = `
                <span class="upload-success">
                    <i class="fas fa-check-circle"></i> PDF subido correctamente
                </span>
                <a href="#" class="preview-pdf" id="preview-pdf" title="Ver PDF">
                    <i class="fas fa-eye"></i> Ver PDF
                </a>
            `;

            // Create a URL for the PDF file to enable preview
            const pdfUrl = URL.createObjectURL(file);
            const newPreviewLink = uploadFeedback.querySelector('#preview-pdf');
            newPreviewLink.addEventListener('click', (e) => {
                e.preventDefault();
                window.open(pdfUrl, '_blank');
            });
        } catch (error) {
            console.error('Error al procesar el PDF:', error.message);
            uploadFeedback.style.display = 'block';
            uploadFeedback.innerHTML = '<span class="upload-error"><i class="fas fa-exclamation-circle"></i> Error al procesar el PDF.</span>';
            progressBar.style.display = 'none';
        }
    });
}
});
function populateFormulario2AddressFields(satData) {
    const isSolicitante = @json(Auth::user()->hasRole('solicitante'));
    const fields = {
        codigo_postal: satData.cp || '',
        calle: satData.nombreVialidad || '',
        numero_exterior: satData.numeroExterior || '',
        numero_interior: satData.numeroInterior || '',
        colonia: satData.colonia || ''
    };

    Object.entries(fields).forEach(([fieldId, value]) => {
        const inputElement = document.getElementById(fieldId);
        const displayElement = document.getElementById(`${fieldId}_display`);

        if (isSolicitante) {
            // For solicitante, update display spans and hidden inputs
            if (displayElement) {
                displayElement.textContent = value || 'No disponible';
            }
            if (inputElement) {
                inputElement.value = value || '';
            }
        } else {
            // For revisor_1, update input fields
            if (inputElement && fieldId !== 'colonia') {
                inputElement.value = value || '';
            }
        }
    });

    // For revisor_1, trigger postal code lookup if cp is available
    if (!isSolicitante && satData.cp) {
        const codigoPostalInput = document.getElementById('codigo_postal');
        if (codigoPostalInput) {
            // Set the postal code and dispatch input event to trigger lookup
            codigoPostalInput.value = satData.cp;
            const inputEvent = new Event('input', { bubbles: true });
            codigoPostalInput.dispatchEvent(inputEvent);

            // Set colonia after lookup (if available in SAT data)
            setTimeout(() => {
                const coloniaSelect = document.getElementById('colonia');
                if (coloniaSelect && satData.colonia) {
                    // Find and select the matching option
                    Array.from(coloniaSelect.options).forEach(option => {
                        if (option.textContent.toLowerCase() === satData.colonia.toLowerCase()) {
                            option.selected = true;
                        }
                    });
                }
            }, 1000); // Delay to allow lookup to complete
        }
    }
}
</script>