@extends('dashboard')

@section('title', 'Registro')
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">
@section('content')
<div class="registration-wrapper">
<div class="registration-container">
    <!-- Left Container: Progress Tracker -->
    <div class="progress-tracker-container">
        <div class="progress-header">
            <div class="progress-percentage">%0 Progresando</div>
        </div>

        <div class="progress-steps">
            <!-- Step 1 -->
            <div class="step active" data-step="1">
                <div class="step-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="step-content">
                    <div class="step-title">Datos Generales y contacto</div>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="step" data-step="2">
                <div class="step-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="step-content">
                    <div class="step-title">Domicilio y Ubicación</div>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="step" data-step="3">
                <div class="step-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="step-content">
                    <div class="step-title">Datos de Constitución</div>
                </div>
            </div>
            
            <!-- Step 4 -->
            <div class="step" data-step="4">
                <div class="step-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="step-content">
                    <div class="step-title">Socios o Accionistas</div>
                </div>
            </div>
            
            <!-- Step 5 -->
            <div class="step" data-step="5">
                <div class="step-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="step-content">
                    <div class="step-title">Documentación Requerida</div>
                </div>
            </div>
            
            <!-- Step 6 -->
            <div class="step" data-step="6">
                <div class="step-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="step-content">
                    <div class="step-title">Finalización del Proyecto</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Container: Form Fields -->
    <div class="form-container">
        <!-- Todas las secciones se cargarán dinámicamente aquí -->
        <div id="form-sections-container">
            <!-- El contenido se cargará mediante AJAX o JavaScript -->
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let currentSection = 1;
    const totalSections = 6;
    const formData = {}; // Almacenar los datos del formulario
    
    // Elementos del DOM
    const sectionsContainer = document.getElementById('form-sections-container');
    const progressPercentage = document.querySelector('.progress-percentage');
    
    // Inicializar el formulario
    loadSection(currentSection);
    updateProgress();
    
    // Función para cargar una sección específica
    function loadSection(sectionNumber) {
        // Obtener la sección correspondiente
        let sectionContent = '';
        
        switch(sectionNumber) {
            case 1:
                sectionContent = getSection1Content();
                break;
            case 2:
                sectionContent = getSection2Content();
                break;
            case 3:
                sectionContent = getSection3Content();
                break;
            case 4:
                sectionContent = getSection4Content();
                break;
            case 5:
                sectionContent = getSection5Content();
                break;
            case 6:
                sectionContent = getSection6Content();
                break;
        }
        
        // Insertar el contenido en el contenedor
        sectionsContainer.innerHTML = sectionContent;
        
        // Configurar los event listeners para los botones de la sección actual
        setupSectionButtons(sectionNumber);
        
        // Si es la última sección, generar resumen
        if (sectionNumber === 6) {
            generateSummary();
        }
    }
    
    // Función para configurar los botones de cada sección
    function setupSectionButtons(sectionNumber) {
        // Botón Siguiente
        const nextButton = document.querySelector('.next-btn');
        if (nextButton) {
            nextButton.addEventListener('click', function() {
                if (validateSection(sectionNumber)) {
                    saveSectionData(sectionNumber);
                    currentSection = sectionNumber + 1;
                    loadSection(currentSection);
                    updateProgress();
                }
            });
        }
        
        // Botón Anterior
        const prevButton = document.querySelector('.prev-btn');
        if (prevButton) {
            prevButton.addEventListener('click', function() {
                currentSection = sectionNumber - 1;
                loadSection(currentSection);
                updateProgress();
            });
        }
        
        // Botón Enviar (solo en la última sección)
        if (sectionNumber === 6) {
            const submitButton = document.getElementById('submit-btn');
            if (submitButton) {
                submitButton.addEventListener('click', function() {
                    if (validateSection(sectionNumber) && document.getElementById('accept_terms').checked) {
                        submitForm();
                    } else {
                        document.querySelector('.formulario__input-error').style.display = 'block';
                    }
                });
            }
        }
    }
    
    // Función para guardar los datos de la sección actual
    function saveSectionData(sectionNumber) {
        // Aquí iría la lógica para guardar los datos del formulario
        // en el objeto formData según la sección actual
    }
    
    // Función para validar la sección actual
    function validateSection(sectionNumber) {
        let isValid = true;
        // Aquí iría la lógica de validación para cada sección
        return isValid;
    }
    
    // Función para actualizar el progreso
    function updateProgress() {
        const progress = Math.round((currentSection / totalSections) * 100);
        progressPercentage.textContent = `%${progress} Progresando`;
        
        // Actualizar los pasos en el tracker
        document.querySelectorAll('.step').forEach((step, index) => {
            const stepNumber = parseInt(step.getAttribute('data-step'));
            if (stepNumber < currentSection) {
                step.classList.add('completed');
                step.classList.remove('active');
            } else if (stepNumber === currentSection) {
                step.classList.remove('completed');
                step.classList.add('active');
            } else {
                step.classList.remove('completed', 'active');
            }
        });
    }
    
    // Función para generar el resumen en la última sección
    function generateSummary() {
        const summaryContainer = document.getElementById('resumen-solicitud');
        if (summaryContainer) {
            summaryContainer.innerHTML = `
                <div class="summary-item">
                    <strong>Razón Social:</strong> <span id="summary-razon-social">${formData.razon_social || 'No proporcionado'}</span>
                </div>
                <div class="summary-item">
                    <strong>RFC:</strong> <span id="summary-rfc">${formData.rfc || 'No proporcionado'}</span>
                </div>
                <div class="summary-item">
                    <strong>Domicilio:</strong> <span id="summary-domicilio">${formData.domicilio || 'No proporcionado'}</span>
                </div>
                <div class="summary-item">
                    <strong>Contacto:</strong> <span id="summary-contacto">${formData.contacto || 'No proporcionado'}</span>
                </div>
            `;
        }
    }
    
    // Función para enviar el formulario
    function submitForm() {
        // Aquí iría la lógica para enviar los datos al servidor
        console.log('Formulario enviado:', formData);
        alert('¡Solicitud enviada con éxito!');
    }
    
    // Funciones que devuelven el contenido de cada sección
    function getSection1Content() {
        return `
            <div id="section-1" class="form-section active-section">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Datos Generales
                        </h2>
                        <div class="form-group custom-select">
                            <label class="form-label" for="sector">Sector al que Pertenece</label>
                            <select id="sector" name="sector" class="form-control">
                                <option value="">Seleccione un sector</option>
                            </select>
                            <p class="formulario__input-error">Debes seleccionar un sector.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="actividad_comercial">Actividades Comerciales</label>
                            <select id="actividad_comercial" name="actividad_comercial" class="form-control">
                                <option value="">Seleccione una actividad</option>
                            </select>
                            <p class="formulario__input-error">Debes seleccionar una actividad comercial.</p>
                        </div>
                        <div class="actividades-contenedor">
                            <div class="actividades-header">
                                <i class="fas fa-list-check"></i> Actividades Seleccionadas
                            </div>
                            <div id="actividades_seleccionadas" class="actividades-lista">
                                <div class="empty-message">No hay actividades seleccionadas</div>
                            </div>
                            <input type="hidden" name="actividades_comerciales" id="actividades_comerciales_input">
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label" for="curp">CURP (Solo si es persona física)</label>
                            <input type="text" id="curp" name="curp" class="form-control" placeholder="Ej: ABCD123456HDFXYZ01" maxlength="18">
                            <p class="formulario__input-error">El CURP no tiene un formato válido.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="section-title">
                            <i class="fas fa-address-card"></i>
                            Datos de Contacto
                        </h2>
                        <div class="form-group">
                            <label class="form-label" for="contacto_nombre">Nombre Completo</label>
                            <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control" placeholder="Ej: Juan Pérez González">
                            <p class="formulario__input-error">El nombre debe contener solo letras y espacios.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contacto_cargo">Cargo o Puesto</label>
                            <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control" placeholder="Ej: Director General">
                            <p class="formulario__input-error">Este campo es obligatorio.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contacto_telefono">Teléfono de Contacto</label>
                            <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control" placeholder="Ej: (951) 145 45 25">
                            <p class="formulario__input-error">El teléfono debe contener entre 7 y 14 números.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contacto_correo">Correo Electrónico</label>
                            <input type="email" id="contacto_correo" name="contacto_correo" class="form-control" placeholder="Ej: contacto@empresa.com">
                            <p class="formulario__input-error">El correo electrónico no es válido.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contacto_web">Página Web</label>
                            <input type="url" id="contacto_web" name="contacto_web" class="form-control" placeholder="Ej: https://www.empresa.com">
                            <p class="formulario__input-error">La URL no es válida.</p>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button class="btn btn-secondary me-2" disabled>Anterior</button>
                        <button class="btn btn-primary next-btn" data-next="2">Siguiente</button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function getSection2Content() {
        return `
            <div id="section-2" class="form-section active-section">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="section-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Domicilio Fiscal
                        </h2>
                        <div class="form-group">
                            <label class="form-label" for="calle">Calle</label>
                            <input type="text" id="calle" name="calle" class="form-control" placeholder="Ej: Av. Independencia">
                            <p class="formulario__input-error">Este campo es obligatorio.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="numero_exterior">Número Exterior</label>
                            <input type="text" id="numero_exterior" name="numero_exterior" class="form-control" placeholder="Ej: 123">
                            <p class="formulario__input-error">Este campo es obligatorio.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="numero_interior">Número Interior (opcional)</label>
                            <input type="text" id="numero_interior" name="numero_interior" class="form-control" placeholder="Ej: 45">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="colonia">Colonia</label>
                            <input type="text" id="colonia" name="colonia" class="form-control" placeholder="Ej: Centro">
                            <p class="formulario__input-error">Este campo es obligatorio.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="section-title">
                            <i class="fas fa-location-dot"></i>
                            Ubicación Geográfica
                        </h2>
                        <div class="form-group">
                            <label class="form-label" for="codigo_postal">Código Postal</label>
                            <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" placeholder="Ej: 68000">
                            <p class="formulario__input-error">El código postal debe tener 5 dígitos.</p>
                        </div>
                        <div class="form-group custom-select">
                            <label class="form-label" for="estado">Estado</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="">Seleccione un estado</option>
                            </select>
                            <p class="formulario__input-error">Debes seleccionar un estado.</p>
                        </div>
                        <div class="form-group custom-select">
                            <label class="form-label" for="municipio">Municipio/Alcaldía</label>
                            <select id="municipio" name="municipio" class="form-control">
                                <option value="">Seleccione un municipio</option>
                            </select>
                            <p class="formulario__input-error">Debes seleccionar un municipio.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="referencias">Referencias (opcional)</label>
                            <textarea id="referencias" name="referencias" class="form-control" rows="2" placeholder="Ej: Entre calles Juárez y Morelos, edificio blanco"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button class="btn btn-secondary me-2 prev-btn" data-prev="1">Anterior</button>
                        <button class="btn btn-primary next-btn" data-next="3">Siguiente</button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function getSection3Content() {
        return `
            <div id="section-3" class="form-section active-section">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="section-title">
                            <i class="fas fa-building"></i>
                            Información Legal
                        </h2>
                        <div class="form-group">
                            <label class="form-label" for="razon_social">Razón Social</label>
                            <input type="text" id="razon_social" name="razon_social" class="form-control" placeholder="Ej: Empresa S.A. de C.V.">
                            <p class="formulario__input-error">Este campo es obligatorio.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="rfc">RFC</label>
                            <input type="text" id="rfc" name="rfc" class="form-control" placeholder="Ej: EMP123456ABC">
                            <p class="formulario__input-error">El RFC no tiene un formato válido.</p>
                        </div>
                        <div class="form-group custom-select">
                            <label class="form-label" for="tipo_sociedad">Tipo de Sociedad</label>
                            <select id="tipo_sociedad" name="tipo_sociedad" class="form-control">
                                <option value="">Seleccione una opción</option>
                                <option value="sa">S.A. (Sociedad Anónima)</option>
                                <option value="srl">S. de R.L. (Sociedad de Responsabilidad Limitada)</option>
                                <option value="sc">S.C. (Sociedad Civil)</option>
                                <option value="otros">Otro tipo</option>
                            </select>
                            <p class="formulario__input-error">Debes seleccionar un tipo de sociedad.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="section-title">
                            <i class="fas fa-calendar-day"></i>
                            Fechas Relevantes
                        </h2>
                        <div class="form-group">
                            <label class="form-label" for="fecha_constitucion">Fecha de Constitución</label>
                            <input type="date" id="fecha_constitucion" name="fecha_constitucion" class="form-control">
                            <p class="formulario__input-error">La fecha no puede ser futura.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fecha_inicio_operaciones">Fecha de Inicio de Operaciones</label>
                            <input type="date" id="fecha_inicio_operaciones" name="fecha_inicio_operaciones" class="form-control">
                            <p class="formulario__input-error">La fecha no puede ser futura.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="capital_social">Capital Social (MXN)</label>
                            <input type="text" id="capital_social" name="capital_social" class="form-control" placeholder="Ej: 100,000.00">
                            <p class="formulario__input-error">El monto debe ser numérico.</p>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button class="btn btn-secondary me-2 prev-btn" data-prev="2">Anterior</button>
                        <button class="btn btn-primary next-btn" data-next="4">Siguiente</button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function getSection4Content() {
        return `
            <div id="section-4" class="form-section active-section">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">
                            <i class="fas fa-users"></i>
                            Información de Socios/Accionistas
                        </h2>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Agrega al menos un socio o accionista.
                        </div>
                        
                        <div class="socios-container">
                            <div class="socio-form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="socio_nombre">Nombre Completo</label>
                                            <input type="text" class="form-control socio_nombre" placeholder="Ej: María González López">
                                            <p class="formulario__input-error">El nombre debe contener solo letras y espacios.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="socio_rfc">RFC</label>
                                            <input type="text" class="form-control socio_rfc" placeholder="Ej: GOLM800101ABC">
                                            <p class="formulario__input-error">El RFC no tiene un formato válido.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="socio_participacion">Participación (%)</label>
                                            <input type="text" class="form-control socio_participacion" placeholder="Ej: 60">
                                            <p class="formulario__input-error">El porcentaje debe ser entre 1 y 100.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-outline-primary btn-sm add-socio-btn">
                                            <i class="fas fa-plus"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="socios-list mt-3">
                                <div class="empty-message">No hay socios registrados</div>
                            </div>
                            <input type="hidden" name="socios_data" id="socios_data">
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button class="btn btn-secondary me-2 prev-btn" data-prev="3">Anterior</button>
                        <button class="btn btn-primary next-btn" data-next="5">Siguiente</button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function getSection5Content() {
        return `
            <div id="section-5" class="form-section active-section">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">
                            <i class="fas fa-file-upload"></i>
                            Documentos Necesarios
                        </h2>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Todos los documentos marcados con (*) son obligatorios.
                        </div>
                        
                        <div class="documentos-list">
                            <div class="documento-item required">
                                <div class="documento-info">
                                    <span class="documento-title">Acta Constitutiva*</span>
                                    <span class="documento-desc">Documento legal que acredita la constitución de la empresa</span>
                                </div>
                                <div class="documento-actions">
                                    <button class="btn btn-outline-primary btn-sm upload-btn">
                                        <i class="fas fa-upload"></i> Subir
                                    </button>
                                </div>
                            </div>
                            
                            <div class="documento-item required">
                                <div class="documento-info">
                                    <span class="documento-title">Identificación Oficial*</span>
                                    <span class="documento-desc">INE, pasaporte o cédula profesional del representante legal</span>
                                </div>
                                <div class="documento-actions">
                                    <button class="btn btn-outline-primary btn-sm upload-btn">
                                        <i class="fas fa-upload"></i> Subir
                                    </button>
                                </div>
                            </div>
                            
                            <div class="documento-item">
                                <div class="documento-info">
                                    <span class="documento-title">Comprobante de Domicilio</span>
                                    <span class="documento-desc">Recibo de luz, agua o teléfono no mayor a 3 meses</span>
                                </div>
                                <div class="documento-actions">
                                    <button class="btn btn-outline-primary btn-sm upload-btn">
                                        <i class="fas fa-upload"></i> Subir
                                    </button>
                                </div>
                            </div>
                            
                            <div class="documento-item required">
                                <div class="documento-info">
                                    <span class="documento-title">RFC*</span>
                                    <span class="documento-desc">Constancia de situación fiscal vigente</span>
                                </div>
                                <div class="documento-actions">
                                    <button class="btn btn-outline-primary btn-sm upload-btn">
                                        <i class="fas fa-upload"></i> Subir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button class="btn btn-secondary me-2 prev-btn" data-prev="4">Anterior</button>
                        <button class="btn btn-primary next-btn" data-next="6">Siguiente</button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function getSection6Content() {
        return `
            <div id="section-6" class="form-section active-section">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="completion-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="section-title">¡Estás a punto de terminar!</h2>
                        <p class="completion-text">Revisa cuidadosamente la información proporcionada antes de enviar tu solicitud.</p>
                        
                        <div class="summary-card">
                            <h4 class="summary-title">Resumen de tu solicitud</h4>
                            <div class="summary-content" id="resumen-solicitud">
                                <!-- Aquí se generará dinámicamente el resumen -->
                            </div>
                        </div>
                        
                        <div class="form-group mt-4 terms-check">
                            <input type="checkbox" id="accept_terms" name="accept_terms">
                            <label for="accept_terms">Acepto los <a href="#" class="terms-link">términos y condiciones</a> y el <a href="#" class="terms-link">aviso de privacidad</a></label>
                            <p class="formulario__input-error">Debes aceptar los términos para continuar.</p>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button class="btn btn-secondary me-2 prev-btn" data-prev="5">Anterior</button>
                        <button class="btn btn-success" id="submit-btn">Enviar Solicitud</button>
                    </div>
                </div>
            </div>
        `;
    }
});
</script>
@endsection