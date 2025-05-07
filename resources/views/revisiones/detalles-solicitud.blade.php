@extends('dashboard')

@section('title', 'Historial de Proveedor')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">

@section('content')
    <div class="dashboard-container">
        <div class="content-wrapper">
            <header class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Historial de Proveedor</h1>
                    <p class="page-subtitle">Gestión de renovaciones y estados de PVs para <span
                            id="supplier-name">Proveedor</span></p>
                </div>
            </header>

            <div id="alert-container"></div>

            <div class="status-tabs">
                <button class="tab-btn active" data-tab="all">
                    <span class="tab-icon"><i class="fas fa-th-list"></i></span>
                    <span class="tab-text">Todos</span>
                    <span class="tab-count" id="count-all">0</span>
                </button>
                <button class="tab-btn" data-tab="formularios">
                    <span class="tab-icon"><i class="fas fa-file-alt"></i></span>
                    <span class="tab-text">Formularios</span>
                </button>
            </div>

            <!-- Sección de PVs del Proveedor -->
            <div class="supplier-pvs" id="supplier-pvs">
                <!-- Las tarjetas se generarán dinámicamente aquí -->
            </div>

            <!-- Modal para detalles de revisión -->
            <div id="review-modal" class="modal">
                <div class="modal-content">
                    <span class="close-modal-btn">×</span>
                    <div id="modal-content">
                        <!-- Contenido dinámico del modal -->
                    </div>
                </div>
            </div>

            <!-- Formulario de revisión -->
            <div id="review-form" class="details-container" style="display: none;">
                <a href="#" class="close-form-btn">× Cerrar</a>
                <form id="formulario1">
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
                            <div class="pdf-preview-container" id="upload-feedback" style="display: none;">
                                <i class="fas fa-file-pdf pdf-icon"></i>
                                <span class="pdf-name upload-success">PDF subido correctamente</span>
                                <button class="view-pdf-btn preview-pdf" id="preview-pdf" title="Ver PDF">
                                    <i class="fas fa-eye"></i> Ver PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-section" id="form-step-1">
                        <h4><i class="fas fa-building"></i> Datos Generales</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width">
                                <label class="form-label data-label">Tipo de Proveedor</label>
                                <select name="tipo_persona" id="tipo_persona" class="form-control" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Física">Física</option>
                                    <option value="Moral">Moral</option>
                                </select>
                                <p class="formulario__input-error">Debe seleccionar 'Física' o 'Moral'.</p>
                            </div>
                            <div class="half-width">
                                <label class="form-label data-label">RFC</label>
                                <input type="text" name="rfc" id="rfc" class="form-control"
                                    placeholder="Ej. XAXX010101000" required maxlength="13" pattern="[A-Z0-9]{12,13}">
                                <p class="formulario__input-error">El RFC debe tener 12 o 13 caracteres alfanuméricos.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--razon_social">
                                <label class="form-label" for="razon_social">Razón Social</label>
                                <input type="text" id="razon_social" name="razon_social" class="form-control" required
                                    maxlength="100" pattern="[A-Za-z\s&.,0-9]+">
                                <p class="formulario__input-error">La razón social debe contener solo letras, números,
                                    espacios y caracteres (&,.,).</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--correo_electronico">
                                <label class="form-label" for="correo_electronico">Correo Electrónico</label>
                                <input type="email" id="correo_electronico" name="correo_electronico"
                                    class="form-control" required>
                                <p class="formulario__input-error">El correo debe tener un formato válido (ej.
                                    usuario@dominio.com).</p>
                            </div>
                        </div>
                        <div class="form-group full-width" id="formulario__grupo--sectores">
                            <label class="form-label">Sectores</label>
                            <select name="sectores" id="sectores" class="form-control">
                                <option value="">Seleccione un sector</option>
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
                            <div id="actividades-seleccionadas" class="actividades-container"></div>
                        </div>
                        <div class="form-group" id="curp-field" style="display: none;">
                            <label class="form-label data-label">CURP</label>
                            <span class="data-field" id="verify-field" style="display: none;">
                                <span class="data-field" id="curp-value">No disponible</span>
                        </div>
                        <div class="horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--contacto_telefono">
                                <label class="form-label" for="contacto_telefono">Teléfono de Contacto</label>
                                <input type="tel" id="contacto_telefono" name="contacto_telefono"
                                    class="form-control" required pattern="[0-9]{10}">
                                <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos
                                    numéricos.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--contacto_web">
                                <label class="form-label" for="contacto_web">Página Web (opcional)</label>
                                <input type="url" id="contacto_web" name="contacto_web" class="form-control"
                                    placeholder="https://www.ejemplo.com">
                                <p class="formulario__input-error">La URL debe ser válida (ej. https://www.empresa.com) o
                                    dejar en blanco.</p>
                            </div>
                        </div>
                        <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
                        <span>Persona encargada de recibir solicitudes y requerimientos</span>
                        <div class="form-group" id="formulario__grupo--contacto_nombre">
                            <label class="form-label" for="contacto_nombre">Nombre Completo</label>
                            <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control"
                                required maxlength="40" pattern="[A-Za-z\s]+">
                            <p class="formulario__input-error">El nombre debe contener solo letras y espacios, máximo 40
                                caracteres.</p>
                        </div>
                        <div class="form-group" id="formulario__grupo--contacto_cargo">
                            <label class="form-label" for="contacto_cargo">Cargo o Puesto</label>
                            <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control"
                                required maxlength="50" pattern="[A-Za-z\s]+">
                            <p class="formulario__input-error">El cargo debe contener solo letras y espacios, máximo 50
                                caracteres.</p>
                        </div>
                        <div class="form-group" id="formulario__grupo--contacto_correo">
                            <label class="form-label" for="contacto_correo">Correo Electrónico</label>
                            <input type="email" id="contacto_correo" name="contacto_correo" class="form-control"
                                required>
                            <p class="formulario__input-error">El correo debe tener un formato válido (ej.
                                usuario@dominio.com).</p>
                        </div>
                        <div class="form-group" id="formulario__grupo--contacto_telefono_2">
                            <label class="form-label" for="contacto_telefono_2">Teléfono de Contacto 2</label>
                            <input type="tel" id="contacto_telefono_2" name="contacto_telefono_2"
                                class="form-control" required pattern="[0-9]{10}">
                            <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos numéricos.
                            </p>
                        </div>
                    </div>
                </form>
                <form id="formulario2">
                    <div class="form-section" id="form-step-2">
                        <h4><i class="fas fa-map-marker-alt"></i> Domicilio</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--codigo_postal">
                                <label class="form-label data-label">Código Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control"
                                    placeholder="Ej: 12345" required pattern="[0-9]{5}" maxlength="5" value="">
                                <p class="formulario__input-error">El código postal debe contener exactamente 5 dígitos
                                    numéricos.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--estado">
                                <label class="form-label data-label">Estado</label>
                                <input type="text" id="estado" name="estado" class="form-control"
                                    placeholder="Ej: Jalisco" readonly value="">
                                <p class="formulario__input-error">El estado debe contener solo letras y espacios, máximo
                                    100 caracteres.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--municipio">
                                <label class="form-label data-label">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control"
                                    placeholder="Ej: Guadalajara" readonly value="">
                                <p class="formulario__input-error">El municipio debe contener solo letras y espacios,
                                    máximo 100 caracteres.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--colonia">
                                <label class="form-label" for="colonia">Asentamiento</label>
                                <select id="colonia" name="colonia" class="form-control" required>
                                    <option value="">Seleccione un Asentamiento</option>
                                </select>
                                <p class="formulario__input-error">Debe seleccionar un asentamiento.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--calle">
                                <label class="form-label" for="calle">Calle</label>
                                <input type="text" id="calle" name="calle" class="form-control"
                                    placeholder="Ej: Av. Principal" required maxlength="100" pattern="[A-Za-z0-9\s]+">
                                <p class="formulario__input-error">La calle debe contener letras, números o espacios,
                                    máximo 100 caracteres.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--numero_exterior">
                                <label class="form-label" for="numero_exterior">Número Exterior</label>
                                <input type="text" id="numero_exterior" name="numero_exterior" class="form-control"
                                    placeholder="Ej: 123" required maxlength="10" pattern="[A-Za-z0-9]+">
                                <p class="formulario__input-error">El número exterior debe contener letras o números,
                                    máximo 10 caracteres.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_interior">
                                <label class="form-label" for="numero_interior">Número Interior</label>
                                <input type="text" id="numero_interior" name="numero_interior" class="form-control"
                                    placeholder="Ej: 5A" maxlength="10" pattern="[A-Za-z0-9]+">
                                <p class="formulario__input-error">El número interior debe contener letras o números,
                                    máximo 10 caracteres, o dejar en blanco.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--entre_calle_1">
                                <label class="form-label" for="entre_calle_1">Entre Calle 1</label>
                                <input type="text" id="entre_calle_1" name="entre_calle_1" class="form-control"
                                    placeholder="Ej: Calle Independencia" maxlength="100" pattern="[A-Za-z0-9\s]+">
                                <p class="formulario__input-error">Entre calle 1 debe contener letras, números o espacios,
                                    máximo 100 caracteres, o dejar en blanco.</p>
                            </div>
                        </div>
                        <div class="form-group" id="formulario__grupo--entre_calle_2">
                            <label class="form-label" for="entre_calle_2">Entre Calle 2</label>
                            <input type="text" id="entre_calle_2" name="entre_calle_2" class="form-control"
                                placeholder="Ej: Calle Morelos" maxlength="100" pattern="[A-Za-z0-9\s]+">
                            <p class="formulario__input-error">Entre calle 2 debe contener letras, números o espacios,
                                máximo 100 caracteres, o dejar en blanco.</p>
                        </div>
                    </div>
                </form>
                <form id="formulario3">
                    <div class="form-section" id="form-step-3">
                        <h4><i class="fas fa-building"></i> Datos de Constitución (Persona Moral)</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_escritura">
                                <label class="form-label" for="numero_escritura">Número de Escritura</label>
                                <input type="text" id="numero_escritura" name="numero_escritura" class="form-control"
                                    placeholder="Ej: 12345">
                                <p class="formulario__input-error">El número de escritura debe contener solo números (máx.
                                    10 dígitos).</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--nombre_notario">
                                <label class="form-label" for="nombre_notario">Nombre del Notario</label>
                                <input type="text" id="nombre_notario" name="nombre_notario" class="form-control"
                                    placeholder="Ej: Lic. Juan Pérez González">
                                <p class="formulario__input-error">El nombre del notario debe contener solo letras y
                                    espacios (máx. 100 caracteres).</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--entidad_federativa">
                                <label class="form-label" for="entidad_federativa">Entidad Federativa</label>
                                <select id="entidad_federativa" name="entidad_federativa" class="form-control">
                                    <option value="">Seleccione un estado</option>
                                </select>
                                <p class="formulario__input-error">Por favor, seleccione una entidad federativa.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--fecha_constitucion">
                                <label class="form-label" for="fecha_constitucion">Fecha de Constitución</label>
                                <input type="date" id="fecha_constitucion" name="fecha_constitucion"
                                    class="form-control">
                                <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_notario">
                                <label class="form-label" for="numero_notario">Número de Notario</label>
                                <input type="text" id="numero_notario" name="numero_notario" class="form-control"
                                    placeholder="Ej: 123">
                                <p class="formulario__input-error">El número de notario debe contener solo números (máx. 10
                                    dígitos).</p>
                            </div>
                            <div class="half-width"></div>
                        </div>
                        <h4><i class="fas fa-file-contract"></i> Datos de Inscripción en el Registro Público</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_registro">
                                <label class="form-label" for="numero_registro">Número de Registro o Folio
                                    Mercantil</label>
                                <input type="text" id="numero_registro" name="numero_registro" class="form-control"
                                    placeholder="Ej: 987654">
                                <p class="formulario__input-error">El número de registro debe contener solo números (máx.
                                    10 dígitos).</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--fecha_inscripcion">
                                <label class="form-label" for="fecha_inscripcion">Fecha de Inscripción</label>
                                <input type="date" id="fecha_inscripcion" name="fecha_inscripcion"
                                    class="form-control">
                                <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="formulario4">
                    <div class="form-section" id="form-step-4">
                        <div class="form-container">
                            <div class="form-column">
                                <div class="form-header">
                                    <h4><i class="fas fa-users"></i> Socios o Accionistas (Persona Moral)</h4>
                                    <p class="subtitle">Agrega los socios o accionistas de la empresa</p>
                                    <div class="percentage-summary">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar" id="percentage-bar"></div>
                                        </div>
                                        <span id="percentage-text">0% asignado</span>
                                    </div>
                                </div>
                                <div class="shareholders-container" id="shareholders-container"></div>
                                <button type="button" id="add-shareholder" class="btn-add-shareholder">
                                    <i class="fas fa-plus-circle"></i> Agregar Socio/Accionista
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="formulario5">
                    <div id="section-5" class="form-section">
                        <div class="form-container">
                            <div class="form-column">
                                <div class="form-group">
                                    <h4><i class="fas fa-user-tie"></i> Datos del Apoderado o Representante Legal</h4>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--nombre-apoderado">
                                        <label class="form-label" for="nombre-apoderado">Nombre</label>
                                        <input type="text" id="nombre-apoderado" name="nombre-apoderado"
                                            class="form-control" placeholder="Ej: Lic. Juan Pérez González">
                                        <p class="formulario__input-error">El nombre solo puede contener letras y espacios,
                                            máximo 100 caracteres.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--numero-escritura">
                                        <label class="form-label" for="numero-escritura">Número de Escritura</label>
                                        <input type="text" id="numero-escritura" name="numero-escritura"
                                            class="form-control" placeholder="Ej: 12345">
                                        <p class="formulario__input-error">El número de escritura debe contener solo
                                            números, máximo 10 dígitos.</p>
                                    </div>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--nombre-notario">
                                        <label class="form-label" for="nombre-notario">Nombre del Notario</label>
                                        <input type="text" id="nombre-notario" name="nombre-notario"
                                            class="form-control" placeholder="Ej: Lic. María López Ramírez">
                                        <p class="formulario__input-error">El nombre del notario solo puede contener letras
                                            y espacios, máximo 100 caracteres.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--numero-notario">
                                        <label class="form-label" for="numero-notario">Número del Notario</label>
                                        <input type="text" id="numero-notario" name="numero-notario"
                                            class="form-control" placeholder="Ej: 123">
                                        <p class="formulario__input-error">El número del notario debe contener solo
                                            números, máximo 10 dígitos.</p>
                                    </div>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--entidad-federativa">
                                        <label class="form-label" for="entidad-federativa">Entidad Federativa</label>
                                        <select id="entidad-federativa" name="entidad-federativa" class="form-control">
                                            <option value="">Seleccione un estado</option>
                                        </select>
                                        <p class="formulario__input-error">Por favor, seleccione una entidad federativa.
                                        </p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--fecha-escritura">
                                        <label class="form-label" for="fecha-escritura">Fecha de Escritura</label>
                                        <input type="date" id="fecha-escritura" name="fecha-escritura"
                                            class="form-control">
                                        <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="formulario6">
                    <div id="section-6" class="form-section">
                        <div class="form-container">
                            <div class="form-column">
                                <div class="document-category">
                                    <div class="folder-item shared-docs">
                                        <div class="folder-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="folder-info">
                                            <h5>Documentos para Ambos (Persona Física y Persona Moral)</h5>
                                        </div>
                                        <div class="folder-actions">
                                            <button class="action-btn more-btn"><i class="fas fa-ellipsis-v"></i></button>
                                        </div>
                                    </div>
                                    <div class="folder-contents">
                                        <div class="file-item formulario__grupo" id="grupo__constancia_situacion_fiscal">
                                            <div class="file-icon">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Constancia de Situación Fiscal</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, vigente, emitido por el SAT, no
                                                    mayor a 3 meses</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="constancia_situacion_fiscal"
                                                    name="constancia_situacion_fiscal" class="file-upload-input"
                                                    accept=".pdf" required>
                                                <label for="constancia_situacion_fiscal"
                                                    class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__identificacion_oficial">
                                            <div class="file-icon">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Identificación Oficial</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original vigente (INE, pasaporte o cédula
                                                    profesional)</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="identificacion_oficial"
                                                    name="identificacion_oficial" class="file-upload-input"
                                                    accept=".pdf" required>
                                                <label for="identificacion_oficial"
                                                    class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__curriculum">
                                            <div class="file-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Curriculum Actualizado</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, con giro, experiencia, clientes y
                                                    recursos</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="curriculum" name="curriculum"
                                                    class="file-upload-input" accept=".pdf" required>
                                                <label for="curriculum" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__comprobante_domicilio">
                                            <div class="file-icon">
                                                <i class="fas fa-home"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Comprobante de Domicilio</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, no mayor a 3 meses</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="comprobante_domicilio"
                                                    name="comprobante_domicilio" class="file-upload-input" accept=".pdf"
                                                    required>
                                                <label for="comprobante_domicilio" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__croquis_fotografias">
                                            <div class="file-icon">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Croquis de Localización y Fotografías</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, del domicilio del proveedor</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="croquis_fotografias" name="croquis_fotografias"
                                                    class="file-upload-input" accept=".pdf" required>
                                                <label for="croquis_fotografias" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__carta_poder">
                                            <div class="file-icon">
                                                <i class="fas fa-file-contract"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Carta Poder Simple</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, con identificación del aceptante,
                                                    si aplica</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="carta_poder" name="carta_poder"
                                                    class="file-upload-input" accept=".pdf">
                                                <label for="carta_poder" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__acuse_recibo">
                                            <div class="file-icon">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Acuse de Recibo</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, última declaración anual y
                                                    provisionales</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="acuse_recibo" name="acuse_recibo"
                                                    class="file-upload-input" accept=".pdf" required>
                                                <label for="acuse_recibo" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="document-category">
                                    <div class="folder-item individual-docs">
                                        <div class="folder-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="folder-info">
                                            <h5>Documentos Exclusivos para Persona Física</h5>
                                        </div>
                                        <div class="folder-actions">
                                            <button class="action-btn more-btn"><i class="fas fa-ellipsis-v"></i></button>
                                        </div>
                                    </div>
                                    <div class="folder-contents">
                                        <div class="file-item formulario__grupo" id="grupo__acta_nacimiento">
                                            <div class="file-icon">
                                                <i class="fas fa-certificate"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Acta de Nacimiento</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, no mayor a 3 meses</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="acta_nacimiento" name="acta_nacimiento"
                                                    class="file-upload-input" accept=".pdf">
                                                <label for="acta_nacimiento" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__curp">
                                            <div class="file-icon">
                                                <i class="fas fa-id-badge"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>CURP</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, formato actualizado</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="curp" name="curp"
                                                    class="file-upload-input" accept=".pdf">
                                                <label for="curp" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="document-category">
                                    <div class="folder-item corporate-docs">
                                        <div class="folder-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div class="folder-info">
                                            <h5>Documentos Exclusivos para Persona Moral</h5>
                                        </div>
                                        <div class="folder-actions">
                                            <button class="action-btn more-btn"><i class="fas fa-ellipsis-v"></i></button>
                                        </div>
                                    </div>
                                    <div class="folder-contents">
                                        <div class="file-item formulario__grupo" id="grupo__acta_constitutiva">
                                            <div class="file-icon">
                                                <i class="fas fa-file-signature"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Acta Constitutiva</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, notariada, inscrita en el
                                                    Registro Público</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="acta_constitutiva" name="acta_constitutiva"
                                                    class="file-upload-input" accept=".pdf">
                                                <label for="acta_constitutiva" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__modificaciones_acta">
                                            <div class="file-icon">
                                                <i class="fas fa-file-contract"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Modificaciones al Acta</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, si aplica</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="modificaciones_acta" name="modificaciones_acta"
                                                    class="file-upload-input" accept=".pdf">
                                                <label for="modificaciones_acta" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                        <div class="file-item formulario__grupo" id="grupo__poder_notariado">
                                            <div class="file-icon">
                                                <i class="fas fa-stamp"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Poder Notariado</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, para actos de
                                                    administración</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="poder_notariado" name="poder_notariado"
                                                    class="file-upload-input" accept=".pdf">
                                                <label for="poder_notariado" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo
                                                10 MB).</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        :root {
            --primary-color: #9D2449;
            /* Primary color for active card */
            --primary-dark: #7a1c38;
            /* Darker shade for active card */
            --primary-light: #f8e8ee;
            /* Light shade for active card */
            --expired-color: #6B7280;
            /* Gray for expired card */
            --expired-dark: #4B5563;
            --expired-light: #D1D5DB;
            --success-color: #10b981;
            --success-light: #d1fae5;
            --success-dark: #059669;
            --danger-color: #f32727;
            --danger-light: #fee2e2;
            --danger-dark: #cc1717;
            --text-dark: #374151;
            --text-medium: #6b7280;
            --text-light: #9ca3af;
            --bg-light: #f9fafb;
            --border-light: #e5e7eb;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --font-primary: 'Inter', 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition-normal: 0.3s ease;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-family: var(--font-primary);
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px 16px;
        }

        .page-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-light);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: var(--text-medium);
            font-size: 14px;
            margin: 0;
        }

        .status-tabs {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
            padding-bottom: 8px;
            overflow-x: auto;
        }

        .tab-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: white;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-medium);
            cursor: pointer;
            transition: all var(--transition-normal);
            white-space: nowrap;
            box-shadow: var(--shadow-md);
            min-width: 100px;
        }

        .tab-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-dark);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.2);
            font-weight: 600;
        }

        .tab-btn:hover:not(.active) {
            background-color: var(--primary-light);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .supplier-pvs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .supplier-card {
            background-color: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            border: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            position: relative;
            height: 100%;
            max-width: 280px;
            overflow: hidden;
        }

        .supplier-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .supplier-card.activo {
            background-color: white;
        }

        /* Fondo blanco para el card-body en tarjetas activas */
        .supplier-card.activo .card-body {
            background-color: white;
        }

        .supplier-card.expirado {
            background-color: white;
            border-color: var(--expired-color);
        }

        .card-header {
            padding: 12px;
            text-align: center;
            position: relative;
        }

        .supplier-card.activo .card-header {
            background: linear-gradient(180deg, var(--primary-light) 0%, white 100%);
        }

        .supplier-card.expirado .card-header {
            background: linear-gradient(180deg, var(--expired-light) 0%, white 100%);
        }

        .supplier-logo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            box-shadow: var(--shadow-md);
            margin: 0 auto 8px;
        }

        .supplier-card.activo .supplier-logo {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        }

        .supplier-card.expirado .supplier-logo {
            background: linear-gradient(135deg, var(--expired-dark) 0%, var(--expired-color) 100%);
        }

        .supplier-name {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
            word-break: break-word;
        }

        .supplier-card.activo .supplier-name {
            color: var(--primary-color);
        }

        .supplier-card.expirado .supplier-name {
            color: var(--expired-color);
        }


        .card-body {
            padding: 12px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            justify-content: center;
        }

        .supplier-card.activo .info-item i {
            color: var(--primary-color);
        }

        .supplier-card.expirado .info-item i {
            color: var(--expired-color);
        }

        .info-label {
            font-size: 10px;
            color: var(--text-light);
            font-weight: 500;
        }

        .info-value {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            box-shadow: var(--shadow-md);
            justify-content: center;
            width: 80px;
            margin: 0 auto;
        }

        .status-pill.activo {
            background-color: var(--success-light);
            color: var(--success-dark);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-pill.activo::before {
            content: "";
            width: 5px;
            height: 5px;
            border-radius: 50%;
            margin-right: 5px;
            background-color: var(--success-color);
        }

        .status-pill.expirado {
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border: 1px solid rgba(243, 39, 39, 0.2);
        }

        .status-pill.expirado::before {
            content: "";
            width: 5px;
            height: 5px;
            border-radius: 50%;
            margin-right: 5px;
            background-color: var(--danger-color);
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            border: none;
            box-shadow: var(--shadow-md);
            width: 100%;
            text-align: center;
        }

        .supplier-card.activo .action-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .supplier-card.expirado .action-btn {
            background-color: var(--expired-color);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .supplier-card.activo .action-btn:hover {
            background-color: var(--primary-dark);
        }

        .supplier-card.expirado .action-btn:hover {
            background-color: var(--expired-dark);
        }

        /* Estilo específico para el botón dentro del modal */
        .modal-body .action-btn {
            background-color: var(--primary-color);
            /* Guinda (#9D2449) */
            color: white;
        }

        .modal-body .action-btn:hover {
            background-color: var(--primary-dark);
            /* Guinda oscuro (#7a1c38) */
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 24px;
            border: none;
            width: 80%;
            max-width: 600px;
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: slideIn 0.4s ease-out;
        }

        .close-modal-btn {
            position: absolute;
            right: 16px;
            top: 16px;
            color: var(--text-medium);
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            background: var(--bg-light);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-normal);
        }

        .close-modal-btn:hover {
            color: var(--primary-color);
            background: var(--primary-light);
            transform: rotate(90deg);
        }

        .modal-header {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            text-align: center;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            background: var(--bg-light);
            padding: 8px 12px;
            border-radius: var(--radius-md);
            transition: all var(--transition-normal);
        }

        .modal-info:hover {
            background: var(--primary-light);
        }

        .modal-info i {
            color: var(--primary-color);
            font-size: 15px;
        }

        .modal-info span {
            font-weight: 500;
            color: var(--text-dark);
        }

        .details-toggle {
            margin-top: 16px;
            border-top: 1px solid var(--border-light);
        }

        .toggle-details-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border: none;
            background-color: transparent;
            color: var(--text-medium);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
        }

        .toggle-details-btn:hover {
            color: var(--primary-color);
        }

        .toggle-details-btn i {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toggle-details-btn.active i {
            transform: rotate(180deg);
        }

        .details-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
        }

        .details-panel.active {
            max-height: 1000px;
            transition: max-height 1s ease-in-out;
        }

        .details-content {
            padding: 12px;
            background-color: var(--bg-light);
            border-radius: var(--radius-md);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-item i {
            color: var(--primary-color);
            font-size: 14px;
        }

        .detail-label {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 500;
        }

        .detail-value {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        #review-form {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        .close-form-btn {
            float: right;
            font-size: 1.1em;
            text-decoration: none;
            color: var(--text-medium);
            padding: 4px 8px;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
        }

        .close-form-btn:hover {
            color: var(--text-dark);
            background-color: var(--bg-light);
        }

        .alert {
            padding: 12px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
        }

        .alert-info {
            background-color: #e0f2fe;
            color: #0369a1;
            border-left: 3px solid #0ea5e9;
        }

        .alert-danger {
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border-left: 3px solid var(--danger-color);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .supplier-pvs {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 90%;
            }

            .page-title {
                font-size: 24px;
            }

            .page-subtitle {
                font-size: 12px;
            }

            .tab-btn {
                padding: 8px 12px;
                font-size: 11px;
            }
        }
    </style>
    <script>
        const testData = {
            supplier: {
                name: "TECNOLOGÍA AVANZADA S.A. DE C.V.",
                rfc: "TAA250101ABC",
                contact_name: "Ing. Laura Méndez",
                phone: "55 1234 5678"
            },
            pvs: [{
                pv_id: "PV-2025-001234",
                status: "activo",
                start_date: "01/01/2025",
                end_date: "31/12/2025",
                registration_date: "15/12/2024",
                responsible_person: "Juan Pérez López",
                documents_completed: 12,
                documents_total: 15,
                observations: "Falta entregar carta poder notariada y comprobante de domicilio actualizado."
            }, {
                pv_id: "PV-2024-001234",
                status: "expirado",
                start_date: "01/01/2024",
                end_date: "31/12/2024",
                registration_date: "20/12/2023",
                responsible_person: "María García Sánchez",
                documents_completed: 15,
                documents_total: 15,
                observations: null
            }]
        };

        document.addEventListener('DOMContentLoaded', function() {
            const supplierName = document.getElementById('supplier-name');
            const supplierPvs = document.getElementById('supplier-pvs');
            const alertContainer = document.getElementById('alert-container');
            const countAll = document.getElementById('count-all');
            const reviewForm = document.getElementById('review-form');
            const reviewModal = document.getElementById('review-modal');
            const modalContent = document.getElementById('modal-content');
            const closeModalBtn = document.querySelector('.close-modal-btn');
            const closeFormBtn = document.querySelector('.close-form-btn');

            function renderAlert(message, type = 'info') {
                alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
            }

            function closeModal() {
                reviewModal.style.display = 'none';
            }

            function closeForm() {
                reviewForm.style.display = 'none';
                supplierPvs.style.display = 'grid';
            }

            closeModalBtn.addEventListener('click', closeModal);
            window.addEventListener('click', function(event) {
                if (event.target === reviewModal) {
                    closeModal();
                }
            });

            closeFormBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeForm();
            });

            function renderPvs(supplier, pvs) {
                supplierPvs.innerHTML = '';
                supplierName.textContent = supplier.name;
                countAll.textContent = pvs.length;

                pvs.forEach(pv => {
                    const card = document.createElement('div');
                    card.className = `supplier-card ${pv.status}`;
                    card.innerHTML = `
                        <div class="card-header">
                            <div class="supplier-logo">${supplier.name.substring(0, 2).toUpperCase()}</div>
                            <h3 class="supplier-name">${supplier.name}</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-item status-container">
                                <span class="status-pill ${pv.status}">${pv.status.charAt(0).toUpperCase() + pv.status.slice(1)}</span>
                            </div>
                            <div class="info-item rfc-container">
                                <div class="rfc-content">
                                    <span class="info-label">RFC:</span>
                                    <span class="info-value">${supplier.rfc}</span>
                                </div>
                            </div>
                            <button class="action-btn review-btn" data-pv-id="${pv.pv_id}">

                                <i class="fas fa-clipboard-check"></i> ${pv.status === 'expirado' ? 'Consultar Datos' : 'Iniciar Revisión'}
                            </button>
                        </div>
                    `;
                    supplierPvs.appendChild(card);
                });

                document.querySelectorAll('.review-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const pvId = this.dataset.pvId;
                        const pv = pvs.find(p => p.pv_id === pvId);
                        modalContent.innerHTML = `
                            <div class="modal-header">
                                <h3 class="modal-title">${pv.status === 'expirado' ? 'Consulta de ' : 'Revisión de '}${pv.pv_id}</h3>
                            </div>
                            <div class="modal-body">
                                <div class="modal-info">
                                    <i class="fas fa-id-card"></i>
                                    <span><strong>PV:</strong> ${pv.pv_id}</span>
                                </div>
                                <div class="modal-info">
                                    <i class="fas fa-calendar"></i>
                                    <span><strong>Vigencia:</strong> ${pv.start_date} - ${pv.end_date}</span>
                                </div>
                                <div class="modal-info">
                                    <i class="fas fa-user"></i>
                                    <span><strong>Contacto:</strong> ${supplier.contact_name}</span>
                                </div>
                                <div class="modal-info">
                                    <i class="fas fa-phone"></i>
                                    <span><strong>Teléfono:</strong> ${supplier.phone}</span>
                                </div>
                                <div class="details-toggle">
                                    <button class="toggle-details-btn">
                                        Detalles del PV <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="details-panel">
                                        <div class="details-content">
                                            <div class="detail-item">
                                                <i class="fas fa-calendar-check"></i>
                                                <div>
                                                    <span class="detail-label">Fecha de Registro</span>
                                                    <span class="detail-value">${pv.registration_date}</span>
                                                </div>
                                            </div>
                                            <div class="detail-item">
                                                <i class="fas fa-file-alt"></i>
                                                <div>
                                                    <span class="detail-label">Documentos</span>
                                                    <span class="detail-value">${pv.documents_completed}/${pv.documents_total}</span>
                                                </div>
                                            </div>
                                            ${pv.observations ? `
                                                        <div class="detail-item">
                                                            <i class="fas fa-comment"></i>
                                                            <div>
                                                                <span class="detail-label">Observaciones</span>
                                                                <span class="detail-value">${pv.observations}</span>
                                                            </div>
                                                        </div>
                                                    ` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        reviewModal.style.display = 'block';

                        const toggleBtn = modalContent.querySelector('.toggle-details-btn');
                        toggleBtn.addEventListener('click', function() {
                            const panel = this.nextElementSibling;
                            const icon = this.querySelector('i');
                            this.classList.toggle('active');
                            panel.classList.toggle('active');
                        });

                        if (pv.status === 'activo') {
                            // solo si es activo, mostrar botón "Iniciar Revisión"
                            const startReviewBtn = document.createElement('button');
                            startReviewBtn.className = 'action-btn';
                            startReviewBtn.innerHTML =
                                '<i class="fas fa-clipboard-check"></i> Iniciar Revisión';
                            startReviewBtn.addEventListener('click', function() {
                                closeModal();
                                supplierPvs.style.display = 'none';
                                reviewForm.style.display = 'block';
                            });
                            modalContent.querySelector('.modal-body').appendChild(startReviewBtn);
                        }

                    });
                });
            }

            document.querySelectorAll('.tab-btn').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove(
                        'active'));
                    this.classList.add('active');

                    const tabType = this.dataset.tab;
                    if (tabType === 'formularios') {
                        supplierPvs.style.display = 'none';
                        reviewForm.style.display = 'block';
                    } else {
                        supplierPvs.style.display = 'grid';
                        reviewForm.style.display = 'none';
                        renderPvs(testData.supplier, testData.pvs);
                    }
                });
            });

            const formularios = document.querySelectorAll(
                '#formulario1, #formulario2, #formulario3, #formulario4, #formulario5, #formulario6');
            formularios.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let hasErrors = false;

                    const inputs = form.querySelectorAll('input[required], select[required]');
                    inputs.forEach(input => {
                        const errorMessage = input.nextElementSibling;
                        if (!input.value || (input.type === 'file' && !input.files
                                .length)) {
                            errorMessage.style.display = 'block';
                            hasErrors = true;
                        } else {
                            errorMessage.style.display = 'none';
                        }
                    });

                    if (!hasErrors) {
                        renderAlert('Formulario enviado correctamente.', 'info');
                    } else {
                        renderAlert('Por favor, complete todos los campos requeridos.', 'danger');
                    }
                });
            });

            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    const feedback = this.closest('.form-group').querySelector(
                        '.pdf-preview-container');
                    if (file && file.type === 'application/pdf' && file.size <= 5 * 1024 * 1024) {
                        feedback.style.display = 'flex';
                        feedback.querySelector('.pdf-name').textContent = file.name;
                    } else {
                        feedback.style.display = 'none';
                        renderAlert('Por favor, seleccione un archivo PDF válido (máximo 5MB).',
                            'danger');
                    }
                });
            });

            let shareholdersCount = 0;
            const maxShareholders = 10;
            let totalPercentage = 0;

            function updatePercentageBar() {
                const percentageBar = document.getElementById('percentage-bar');
                const percentageText = document.getElementById('percentage-text');
                percentageBar.style.width = `${totalPercentage}%`;
                percentageText.textContent = `${totalPercentage}% asignado`;

                if (totalPercentage > 100) {
                    percentageBar.style.backgroundColor = 'var(--danger-color)';
                    renderAlert('La suma de los porcentajes no puede exceder el 100%.', 'danger');
                } else {
                    percentageBar.style.backgroundColor = 'var(--primary-color)';
                }
            }

            function addShareholder(name = '', percentage = '') {
                if (shareholdersCount >= maxShareholders) {
                    renderAlert(`No se pueden agregar más de ${maxShareholders} socios/accionistas.`, 'danger');
                    return;
                }

                shareholdersCount++;
                const shareholderId = `shareholder-${shareholdersCount}`;
                const container = document.getElementById('shareholders-container');
                const shareholderDiv = document.createElement('div');
                shareholderDiv.className = 'shareholder-item';
                shareholderDiv.id = shareholderId;
                shareholderDiv.innerHTML = `
                    <div class="form-group horizontal-group">
                        <div class="half-width">
                            <label class="form-label" for="${shareholderId}-name">Nombre del Socio/Accionista</label>
                            <input type="text" id="${shareholderId}-name" name="${shareholderId}-name" class="form-control" value="${name}" required maxlength="100" pattern="[A-Za-z\s]+">
                            <p class="formulario__input-error">El nombre debe contener solo letras y espacios.</p>
                        </div>
                        <div class="half-width">
                            <label class="form-label" for="${shareholderId}-percentage">Porcentaje de Participación</label>
                            <input type="number" id="${shareholderId}-percentage" name="${shareholderId}-percentage" class="form-control" value="${percentage}" min="0" max="100" step="0.01" required>
                            <p class="formulario__input-error">El porcentaje debe estar entre 0 y 100.</p>
                        </div>
                    </div>
                    <button type="button" class="remove-shareholder btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                `;
                container.appendChild(shareholderDiv);

                const percentageInput = document.getElementById(`${shareholderId}-percentage`);
                percentageInput.addEventListener('input', function() {
                    totalPercentage = Array.from(container.querySelectorAll('input[type="number"]'))
                        .reduce((sum, input) => sum + (parseFloat(input.value) || 0), 0);
                    updatePercentageBar();
                });

                shareholderDiv.querySelector('.remove-shareholder').addEventListener('click', function() {
                    const percentage = parseFloat(percentageInput.value) || 0;
                    totalPercentage -= percentage;
                    shareholderDiv.remove();
                    shareholdersCount--;
                    updatePercentageBar();
                });

                updatePercentageBar();
            }

            document.getElementById('add-shareholder').addEventListener('click', () => addShareholder());

            renderPvs(testData.supplier, testData.pvs);
        });
    </script>
@endsection
