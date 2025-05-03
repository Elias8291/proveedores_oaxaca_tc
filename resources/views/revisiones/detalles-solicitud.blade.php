@extends('dashboard')

@section('title', 'Historial de Proveedor')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/formularios.CSS') }}">

@section('content')
<div class="dashboard-container">
    <div class="content-wrapper">
        <header class="page-header">
            <div class="header-content">
                <h1 class="page-title">Historial de Proveedor</h1>
                <p class="page-subtitle">Gestión de renovaciones y estados de PVs para <span id="supplier-name">Proveedor</span></p>
            </div>
        </header>

        <div id="alert-container"></div>

        <div class="status-tabs">
            <button class="tab-btn active" data-filter="all">
                <span class="tab-icon"><i class="fas fa-th-list"></i></span>
                <span class="tab-text">Todos</span>
                <span class="tab-count" id="count-all">0</span>
            </button>
            <button class="tab-btn" data-filter="active">
                <span class="tab-icon"><i class="fas fa-check-circle"></i></span>
                <span class="tab-text">Activos</span>
                <span class="tab-count" id="count-active">0</span>
            </button>
            <button class="tab-btn" data-filter="pending">
                <span class="tab-icon"><i class="fas fa-clock"></i></span>
                <span class="tab-text">En Revisión</span>
                <span class="tab-count" id="count-pending">0</span>
            </button>
            <button class="tab-btn" data-filter="expired">
                <span class="tab-icon"><i class="fas fa-exclamation-circle"></i></span>
                <span class="tab-text">Vencidos</span>
                <span class="tab-count" id="count-expired">0</span>
            </button>
        </div>

        <!-- Sección de PVs del Proveedor -->
        <div class="supplier-pvs" id="supplier-pvs">
            <!-- Formulario para PVs en revisión -->
            <div class="details-container" id="review-form" style="display: none;">
                <form id="formulario1">
                    <!-- Sección para subir Constancia de Situación Fiscal, visible solo para revisor_1 -->
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
                
                    <!-- Resto del formulario -->
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
                        <!-- Campos visibles solo para revisor_1 -->
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
                            <div id="actividades-seleccionadas" class="actividades-container">
                                <!-- Actividades seleccionadas se añadirán aquí dinámicamente -->
                            </div>
                        </div>
                        <!-- CURP field, initially hidden for revisor_1, shown dynamically if tipo_persona is Física -->
                        <div class="form-group" id="curp-field" style="display: none;">
                            <label class="form-label data-label">CURP</label>
                            <span class="data-field" id="curp-value">No disponible</span>
                        </div>
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
                
                <form id="formulario2">
                    <div class="form-section" id="form-step-2">
                        <h4><i class="fas fa-map-marker-alt"></i> Domicilio</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--codigo_postal">
                                <label class="form-label data-label">Código Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" placeholder="Ej: 12345" required pattern="[0-9]{5}" maxlength="5" value="">
                                <p class="formulario__input-error">El código postal debe contener exactamente 5 dígitos numéricos.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--estado">
                                <label class="form-label data-label">Estado</label>
                                <input type="text" id="estado" name="estado" class="form-control" placeholder="Ej: Jalisco" readonly value="">
                                <p class="formulario__input-error">El estado debe contener solo letras y espacios, máximo 100 caracteres.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--municipio">
                                <label class="form-label data-label">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" placeholder="Ej: Guadalajara" readonly value="">
                                <p class="formulario__input-error">El municipio debe contener solo letras y espacios, máximo 100 caracteres.</p>
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
                                <input type="text" id="calle" name="calle" class="form-control" placeholder="Ej: Av. Principal" required maxlength="100" pattern="[A-Za-z0-9\s]+">
                                <p class="formulario__input-error">La calle debe contener letras, números o espacios, máximo 100 caracteres.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--numero_exterior">
                                <label class="form-label" for="numero_exterior">Número Exterior</label>
                                <input type="text" id="numero_exterior" name="numero_exterior" class="form-control" placeholder="Ej: 123" required maxlength="10" pattern="[A-Za-z0-9]+">
                                <p class="formulario__input-error">El número exterior debe contener letras o números, máximo 10 caracteres.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_interior">
                                <label class="form-label" for="numero_interior">Número Interior</label>
                                <input type="text" id="numero_interior" name="numero_interior" class="form-control" placeholder="Ej: 5A" maxlength="10" pattern="[A-Za-z0-9]+">
                                <p class="formulario__input-error">El número interior debe contener letras o números, máximo 10 caracteres, o dejar en blanco.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--entre_calle_1">
                                <label class="form-label" for="entre_calle_1">Entre Calle 1</label>
                                <input type="text" id="entre_calle_1" name="entre_calle_1" class="form-control" placeholder="Ej: Calle Independencia" maxlength="100" pattern="[A-Za-z0-9\s]+">
                                <p class="formulario__input-error">Entre calle 1 debe contener letras, números o espacios, máximo 100 caracteres, o dejar en blanco.</p>
                            </div>
                        </div>
                        <div class="form-group" id="formulario__grupo--entre_calle_2">
                            <label class="form-label" for="entre_calle_2">Entre Calle 2</label>
                            <input type="text" id="entre_calle_2" name="entre_calle_2" class="form-control" placeholder="Ej: Calle Morelos" maxlength="100" pattern="[A-Za-z0-9\s]+">
                            <p class="formulario__input-error">Entre calle 2 debe contener letras, números o espacios, máximo 100 caracteres, o dejar en blanco.</p>
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
                                <p class="formulario__input-error">El número de escritura debe contener solo números (máx. 10 dígitos).</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--nombre_notario">
                                <label class="form-label" for="nombre_notario">Nombre del Notario</label>
                                <input type="text" id="nombre_notario" name="nombre_notario" class="form-control"
                                    placeholder="Ej: Lic. Juan Pérez González">
                                <p class="formulario__input-error">El nombre del notario debe contener solo letras y espacios (máx. 100 caracteres).</p>
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
                                <input type="date" id="fecha_constitucion" name="fecha_constitucion" class="form-control">
                                <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                            </div>
                        </div>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_notario">
                                <label class="form-label" for="numero_notario">Número de Notario</label>
                                <input type="text" id="numero_notario" name="numero_notario" class="form-control"
                                    placeholder="Ej: 123">
                                <p class="formulario__input-error">El número de notario debe contener solo números (máx. 10 dígitos).</p>
                            </div>
                            <div class="half-width"></div> <!-- Espacio vacío para mantener el diseño -->
                        </div>
                        <h4><i class="fas fa-file-contract"></i> Datos de Inscripción en el Registro Público</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_registro">
                                <label class="form-label" for="numero_registro">Número de Registro o Folio Mercantil</label>
                                <input type="text" id="numero_registro" name="numero_registro" class="form-control"
                                    placeholder="Ej: 987654">
                                <p class="formulario__input-error">El número de registro debe contener solo números (máx. 10 dígitos).</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--fecha_inscripcion">
                                <label class="form-label" for="fecha_inscripcion">Fecha de Inscripción</label>
                                <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" class="form-control">
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
                
                                <div class="shareholders-container" id="shareholders-container">
                                    <!-- Tarjetas de accionistas se agregan dinámicamente -->
                                </div>
                
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
                            <!-- Primera columna -->
                            <div class="form-column">
                                <div class="form-group">
                                    <h4><i class="fas fa-user-tie"></i> Datos del Apoderado o Representante Legal</h4>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--nombre-apoderado">
                                        <label class="form-label" for="nombre-apoderado">Nombre</label>
                                        <input type="text" id="nombre-apoderado" name="nombre-apoderado" class="form-control"
                                            placeholder="Ej: Lic. Juan Pérez González">
                                        <p class="formulario__input-error">El nombre solo puede contener letras y espacios, máximo 100 caracteres.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--numero-escritura">
                                        <label class="form-label" for="numero-escritura">Número de Escritura</label>
                                        <input type="text" id="numero-escritura" name="numero-escritura" class="form-control"
                                            placeholder="Ej: 12345">
                                        <p class="formulario__input-error">El número de escritura debe contener solo números, máximo 10 dígitos.</p>
                                    </div>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--nombre-notario">
                                        <label class="form-label" for="nombre-notario">Nombre del Notario</label>
                                        <input type="text" id="nombre-notario" name="nombre-notario" class="form-control"
                                            placeholder="Ej: Lic. María López Ramírez">
                                        <p class="formulario__input-error">El nombre del notario solo puede contener letras y espacios, máximo 100 caracteres.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--numero-notario">
                                        <label class="form-label" for="numero-notario">Número del Notario</label>
                                        <input type="text" id="numero-notario" name="numero-notario" class="form-control"
                                            placeholder="Ej: 123">
                                        <p class="formulario__input-error">El número del notario debe contener solo números, máximo 10 dígitos.</p>
                                    </div>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--entidad-federativa">
                                        <label class="form-label" for="entidad-federativa">Entidad Federativa</label>
                                        <select id="entidad-federativa" name="entidad-federativa" class="form-control">
                                            <option value="">Seleccione un estado</option>
                                        </select>
                                        <p class="formulario__input-error">Por favor, seleccione una entidad federativa.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--fecha-escritura">
                                        <label class="form-label" for="fecha-escritura">Fecha de Escritura</label>
                                        <input type="date" id="fecha-escritura" name="fecha-escritura" class="form-control">
                                        <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Segunda columna -->
                            <div class="form-column">
                                <div class="form-group">
                                    <h4><i class="fas fa-book"></i> Datos de Inscripción en el Registro Público</h4>
                                </div>
                                <div class="form-group horizontal-group">
                                    <div class="half-width form-group" id="formulario__grupo--numero-registro">
                                        <label class="form-label" for="numero-registro">Número de Registro o Folio Mercantil</label>
                                        <input type="text" id="numero-registro" name="numero-registro" class="form-control"
                                            placeholder="Ej: 987654">
                                        <p class="formulario__input-error">El número de registro debe contener solo números, máximo 10 dígitos.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--fecha-inscripcion">
                                        <label class="form-label" for="fecha-inscripcion">Fecha de Inscripción</label>
                                        <input type="date" id="fecha-inscripcion" name="fecha-inscripcion" class="form-control">
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
                                <!-- Documentos para ambos (Persona Física y Persona Moral) -->
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
                                        <!-- Constancia de Situación Fiscal -->
                                        <div class="file-item formulario__grupo" id="grupo__constancia_situacion_fiscal">
                                            <div class="file-icon">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Constancia de Situación Fiscal</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, vigente, emitido por el SAT, no mayor a 3 meses</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="constancia_situacion_fiscal" name="constancia_situacion_fiscal" class="file-upload-input" accept=".pdf" required>
                                                <label for="constancia_situacion_fiscal" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Identificación Oficial -->
                                        <div class="file-item formulario__grupo" id="grupo__identificacion_oficial">
                                            <div class="file-icon">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Identificación Oficial</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original vigente (INE, pasaporte o cédula profesional)</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="identificacion_oficial" name="identificacion_oficial" class="file-upload-input" accept=".pdf" required>
                                                <label for="identificacion_oficial" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Curriculum Actualizado -->
                                        <div class="file-item formulario__grupo" id="grupo__curriculum">
                                            <div class="file-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Curriculum Actualizado</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, con giro, experiencia, clientes y recursos</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="curriculum" name="curriculum" class="file-upload-input" accept=".pdf" required>
                                                <label for="curriculum" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Comprobante de Domicilio -->
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
                                                <input type="file" id="comprobante_domicilio" name="comprobante_domicilio" class="file-upload-input" accept=".pdf" required>
                                                <label for="comprobante_domicilio" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Croquis de Localización y Fotografías -->
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
                                                <input type="file" id="croquis_fotografias" name="croquis_fotografias" class="file-upload-input" accept=".pdf" required>
                                                <label for="croquis_fotografias" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Carta Poder Simple -->
                                        <div class="file-item formulario__grupo" id="grupo__carta_poder">
                                            <div class="file-icon">
                                                <i class="fas fa-file-contract"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Carta Poder Simple</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, con identificación del aceptante, si aplica</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="carta_poder" name="carta_poder" class="file-upload-input" accept=".pdf">
                                                <label for="carta_poder" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Acuse de Recibo -->
                                        <div class="file-item formulario__grupo" id="grupo__acuse_recibo">
                                            <div class="file-icon">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Acuse de Recibo</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, última declaración anual y provisionales</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="acuse_recibo" name="acuse_recibo" class="file-upload-input" accept=".pdf" required>
                                                <label for="acuse_recibo" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Documentos Exclusivos para Persona Física -->
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
                                        <!-- Acta de Nacimiento -->
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
                                                <input type="file" id="acta_nacimiento" name="acta_nacimiento" class="file-upload-input" accept=".pdf">
                                                <label for="acta_nacimiento" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- CURP -->
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
                                                <input type="file" id="curp" name="curp" class="file-upload-input" accept=".pdf">
                                                <label for="curp" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Documentos Exclusivos para Persona Moral -->
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
                                        <!-- Acta Constitutiva -->
                                        <div class="file-item formulario__grupo" id="grupo__acta_constitutiva">
                                            <div class="file-icon">
                                                <i class="fas fa-file-signature"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Acta Constitutiva</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, notariada, inscrita en el Registro Público</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="acta_constitutiva" name="acta_constitutiva" class="file-upload-input" accept=".pdf">
                                                <label for="acta_constitutiva" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Modificaciones al Acta -->
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
                                                <input type="file" id="modificaciones_acta" name="modificaciones_acta" class="file-upload-input" accept=".pdf">
                                                <label for="modificaciones_acta" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
                                        </div>
                
                                        <!-- Poder Notariado -->
                                        <div class="file-item formulario__grupo" id="grupo__poder_notariado">
                                            <div class="file-icon">
                                                <i class="fas fa-stamp"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Poder Notariado</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Copia simple, para actos de administración</span>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="poder_notariado" name="poder_notariado" class="file-upload-input" accept=".pdf">
                                                <label for="poder_notariado" class="file-upload-label">Subir</label>
                                            </div>
                                            <div class="file-status" data-status="pending">
                                                <span class="status-icon"><i class="fas fa-clock"></i></span>
                                                <span class="status-text">Pendiente</span>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <button class="preview-btn" title="Ver PDF"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido (máximo 10 MB).</p>
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
</div>

<style>

    .content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
    }
    
    /* Encabezado de página */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .header-content {
        flex: 1;
    }
    
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }
    
    /* Tabs de estado */
    .status-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        overflow-x: auto;
        padding-bottom: 8px;
    }
    
    .tab-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    
    .tab-btn.active {
        background-color: var(--color-primary-bg);
        color: var(--color-primary-dark);
        border-color: var(--color-primary-light);
    }
    
    .tab-btn:hover:not(.active) {
        background-color: #f9fafb;
    }
    
    .tab-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-neutral);
    }
    
    .tab-btn.active .tab-icon {
        color: var(--color-primary);
    }
    
    .tab-count {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        background-color: #f3f4f6;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
    }
    
    .tab-btn.active .tab-count {
        background-color: rgba(37, 99, 235, 0.2);
        color: var(--color-primary-dark);
    }
    
    /* Lista de PVs */
    .supplier-pvs {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    /* Tarjeta de PV */
    .supplier-card {
        background-color: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .supplier-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    
    .supplier-card.active {
        border-top: 3px solid var(--color-primary);
    }
    
    .supplier-card.pending {
        border-top: 3px solid var(--color-warning);
    }
    
    .supplier-card.expired {
        border-top: 3px solid var(--color-neutral);
    }
    
    /* Encabezado de tarjeta */
    .card-header {
        display: flex;
        padding: 16px;
        gap: 12px;
        border-bottom: 1px solid #f3f4f6;
        position: relative;
    }
    
    .supplier-logo {
        width: 48px;
        height: 48px;
        background-color: var(--color-primary-bg);
        color: var(--color-primary);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
        flex-shrink: 0;
    }
    
    .supplier-logo.expired {
        background-color: #f3f4f6;
        color: var(--color-neutral);
    }
    
    .supplier-logo.pending {
        background-color: var(--color-warning-bg);
        color: var(--color-warning);
    }
    
    .supplier-info {
        flex: 1;
        min-width: 0;
    }
    
    .supplier-info h3 {
        margin: 0 0 8px 0;
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .supplier-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 13px;
        color: #6b7280;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .supplier-status {
        position: absolute;
        top: 16px;
        right: 16px;
    }
    
    /* Pills de estado */
    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }
    
    .status-pill.active {
        background-color: var(--color-success-bg);
        color: var(--color-success);
    }
    
    .status-pill.pending,
    .status-pill.revision {
        background-color: var(--color-warning-bg);
        color: var(--color-warning);
    }
    
    .status-pill.expired {
        background-color: #f3f4f6;
        color: var(--color-neutral);
    }
    
    .status-pill.completed {
        background-color: var(--color-primary-bg);
        color: var(--color-primary);
    }
    
    /* Cuerpo de tarjeta */
    .card-body {
        padding: 16px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    
    .info-item {
        display: flex;
        gap: 10px;
    }
    
    .info-item i {
        color: var(--color-primary);
        font-size: 16px;
        margin-top: 2px;
    }
    
    .info-content {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 2px;
    }
    
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #111827;
    }
    
    /* Resumen de estado */
    .status-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background-color: #f9fafb;
        border-radius: var(--radius-md);
        margin-top: 16px;
    }
    
    .document-progress {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #6b7280;
    }
    
    .progress-bar {
        width: 120px;
        height: 6px;
        background-color: #e5e7eb;
        border-radius: var(--radius-full);
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background-color: var(--color-primary);
    }
    
    .status-warning {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px;
        background-color: var(--color-danger-bg);
        border-radius: var(--radius-md);
        color: var(--color-danger);
        font-size: 13px;
        font-weight: 500;
        margin-top: 16px;
    }
    
    /* Toggle de historial */
    .history-toggle {
        padding: 0 16px;
    }
    
    .toggle-history-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border: none;
        background-color: transparent;
        color: var(--color-primary);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border-top: 1px solid #f3f4f6;
    }
    
    .toggle-history-btn:hover {
        background-color: var(--color-primary-bg);
    }
    
    .toggle-history-btn i {
        transition: transform 0.3s ease;
    }
    
    .toggle-history-btn.active i {
        transform: rotate(180deg);
    }
    
    /* Panel de historial */
    .history-panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .history-panel.active {
        max-height: 1000px;
    }
    
    /* Timeline */
    .timeline {
        position: relative;
        padding: 16px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 16px;
        bottom: 16px;
        width: 2px;
        background-color: #e5e7eb;
    }
    
    .timeline-item {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
        position: relative;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-marker {
        position: relative;
        z-index: 1;
    }
    
    .year-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background-color: #e5e7eb;
        color: #4b5563;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 600;
    }
    
    .timeline-item.current .year-badge {
        background-color: var(--color-primary);
        color: white;
    }
    
    .timeline-content {
        flex: 1;
        min-width: 0;
    }
    
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .period-label {
        font-size: 13px;
        color: #4b5563;
    }
    
    .period-status {
        display: flex;
        gap: 6px;
    }
    
    .timeline-details {
        background-color: white;
        border-radius: var(--radius-md);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 12px;
    }
    
    .detail-row {
        display: grid;
        grid-template-columns: 24px auto 1fr;
        gap: 8px;
        padding: 10px 12px;
        border-bottom: 1px solid #f3f4f6;
        align-items: start;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-icon {
        color: var(--color-primary);
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .detail-label {
        font-size: 13px;
        color: #6b7280;
        white-space: nowrap;
    }
    
    .detail-value {
        font-size: 13px;
        color: #111827;
    }
    
    /* Acciones del timeline */
    .timeline-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .action-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: var(--radius-md);
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid;
    }
    
    .action-btn.view {
        background-color: var(--color-primary-bg);
        color: var(--color-primary);
        border-color: rgba(37, 99, 235, 0.2);
    }
    
    .action-btn.view:hover {
        background-color: rgba(37, 99, 235, 0.15);
    }
    
    .action-btn.approve {
        background-color: var(--color-success-bg);
        color: var(--color-success);
        border-color: rgba(22, 163, 74, 0.2);
    }
    
    .action-btn.approve:hover {
        background-color: rgba(22, 163, 74, 0.15);
    }
    
    .action-btn.request {
        background-color: var(--color-warning-bg);
        color: var(--color-warning);
        border-color: rgba(202, 138, 4, 0.2);
    }
    
    .action-btn.request:hover {
        background-color: rgba(202, 138, 4, 0.15);
    }
    
    /* Pie de tarjeta */
    .card-footer {
        display: flex;
        padding: 16px;
        gap: 12px;
        border-top: 1px solid #f3f4f6;
        background-color: #f9fafb;
    }
    
    .footer-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        flex: 1;
    }
    
    .footer-action.primary {
        background-color: var(--color-primary);
        color: white;
        border: none;
    }
    
    .footer-action.primary:hover {
        background-color: var(--color-primary-dark);
    }
    
    .footer-action.secondary {
        background-color: white;
        color: #374151;
        border: 1px solid #e5e7eb;
    }
    
    .footer-action.secondary:hover {
        background-color: #f3f4f6;
    }
    
    /* Alertas */
    .alert {
        padding: 12px;
        border-radius: var(--radius-md);
        margin-bottom: 16px;
    }
    
    .alert-info {
        background-color: var(--color-primary-bg);
        color: var(--color-primary);
    }
    
    .alert-danger {
        background-color: var(--color-danger-bg);
        color: var(--color-danger);
    }
    
    /* Estilos responsivos */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .timeline-actions {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
        
        .card-footer {
            flex-direction: column;
        }
    }
    
    @media (max-width: 480px) {
        .status-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 12px;
            margin-bottom: 16px;
            -webkit-overflow-scrolling: touch;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .supplier-meta {
            flex-direction: column;
            gap: 6px;
        }
        
        .timeline-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .period-status {
            margin-top: 6px;
        }
        
        .detail-row {
            grid-template-columns: 24px 1fr;
        }
        
        .detail-label {
            grid-column: 2;
        }
        
        .detail-value {
            grid-column: 2;
        }
    }
    </style>
<script>
// Test data
const testData = {
    supplier: {
        name: "TECNOLOGÍA AVANZADA S.A. DE C.V.",
        rfc: "TAA250101ABC",
        contact_name: "Ing. Laura Méndez",
        phone: "55 1234 5678"
    },
    pvs: [
        {
            pv_id: "PV-2025-001234",
            status: "active",
            start_date: "01/01/2025",
            end_date: "31/12/2025",
            registration_date: "15/12/2024",
            responsible_person: "Juan Pérez López",
            documents_completed: 12,
            documents_total: 15,
            observations: "Falta entregar carta poder notariada y comprobante de domicilio actualizado."
        },
        {
            pv_id: "PV-2024-001234",
            status: "expired",
            start_date: "01/01/2024",
            end_date: "31/12/2024",
            registration_date: "20/12/2023",
            responsible_person: "María García Sánchez",
            documents_completed: 15,
            documents_total: 15,
            observations: null
        }
    ]
};

document.addEventListener('DOMContentLoaded', function () {
    const supplierName = document.getElementById('supplier-name');
    const supplierPvs = document.getElementById('supplier-pvs');
    const alertContainer = document.getElementById('alert-container');
    const countAll = document.getElementById('count-all');
    const countActive = document.getElementById('count-active');
    const countPending = document.getElementById('count-pending');
    const countExpired = document.getElementById('count-expired');
    const reviewForm = document.getElementById('review-form');

    // Function to render alert
    function renderAlert(message, type = 'info') {
        alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    }

    // Function to render PV cards
    function renderPvs(supplier, pvs) {
        supplierPvs.innerHTML = '';
        supplierName.textContent = supplier.name;

        // Update tab counts
        const activeCount = pvs.filter(pv => pv.status === 'active').length;
        const pendingCount = pvs.filter(pv => pv.status === 'pending').length;
        const expiredCount = pvs.filter(pv => pv.status === 'expired').length;
        countAll.textContent = pvs.length;
        countActive.textContent = activeCount;
        countPending.textContent = pendingCount;
        countExpired.textContent = expiredCount;

        if (pvs.length === 0) {
            supplierPvs.innerHTML = '<div class="alert alert-info">No se encontraron PVs para este proveedor.</div>';
            return;
        }

        // Show review form if there are pending PVs
        if (pendingCount > 0) {
            reviewForm.style.display = 'block';
        } else {
            reviewForm.style.display = 'none';
        }

        pvs.forEach((pv, index) => {
            if (pv.status !== 'pending') {
                const cardHtml = `
                    <div class="supplier-card ${pv.status}" data-status="${pv.status}">
                        <div class="card-header">
                            <div class="supplier-logo ${pv.status}">
                                <span>${supplier.name.substring(0, 2).toUpperCase()}</span>
                            </div>
                            <div class="supplier-info">
                                <h3>${supplier.name}</h3>
                                <div class="supplier-meta">
                                    <span class="meta-item"><i class="fas fa-id-card"></i> ${pv.pv_id}</span>
                                    <span class="meta-item"><i class="fas fa-file-invoice"></i> RFC: ${supplier.rfc}</span>
                                </div>
                            </div>
                            <div class="supplier-status">
                                <span class="status-pill ${pv.status}">${pv.status.charAt(0).toUpperCase() + pv.status.slice(1)}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div class="info-content">
                                        <span class="info-label">Vigencia</span>
                                        <span class="info-value">${pv.start_date} - ${pv.end_date}</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-user-tie"></i>
                                    <div class="info-content">
                                        <span class="info-label">Contacto</span>
                                        <span class="info-value">${supplier.contact_name}</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <div class="info-content">
                                        <span class="info-label">Teléfono</span>
                                        <span class="info-value">${supplier.phone}</span>
                                    </div>
                                </div>
                            </div>
                            ${pv.status === 'expired' ? `
                                <div class="status-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Registro vencido - Se requiere crear nuevo PV</span>
                                </div>
                            ` : ''}
                        </div>
                        <div class="history-toggle">
                            <button class="toggle-history-btn" data-target="history-${index}">
                                <span>Ver detalles de este PV</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="history-${index}" class="history-panel">
                            <div class="timeline">
                                <div class="timeline-item ${pv.status === 'active' ? 'current' : 'completed'}">
                                    <div class="timeline-marker">
                                        <span class="year-badge">${new Date(pv.end_date.split('/')[2]).getFullYear()}</span>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <div class="period-label">${pv.start_date} - ${pv.end_date}</div>
                                            <div class="period-status">
                                                <span class="status-pill ${pv.status}">${pv.status.charAt(0).toUpperCase() + pv.status.slice(1)}</span>
                                            </div>
                                        </div>
                                        <div class="timeline-details">
                                            <div class="detail-row">
                                                <div class="detail-icon"><i class="fas fa-calendar-check"></i></div>
                                                <div class="detail-label">Registro:</div>
                                                <div class="detail-value">${pv.registration_date}</div>
                                            </div>
                                            <div class="detail-row">
                                                <div class="detail-icon"><i class="fas fa-user-shield"></i></div>
                                                <div class="detail-label">Responsable:</div>
                                                <div class="detail-value">${pv.responsible_person}</div>
                                            </div>
                                            ${pv.observations ? `
                                                <div class="detail-row">
                                                    <div class="detail-icon"><i class="fas fa-comment-alt"></i></div>
                                                    <div class="detail-label">Observaciones:</div>
                                                    <div class="detail-value">${pv.observations}</div>
                                                </div>
                                            ` : ''}
                                        </div>
                                        <div class="timeline-actions">
                                            <button class="action-btn view"><i class="fas fa-search"></i> ${pv.status === 'expired' ? 'Ver Documentos' : 'Revisar Documentos'}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            ${pv.status === 'expired' ? `
                                <button class="footer-action primary">
                                    <i class="fas fa-plus-circle"></i> Crear Nuevo PV
                                </button>
                            ` : `
                                <button class="footer-action primary">
                                    <i class="fas fa-file-alt"></i> Ver Detalles Completos
                                </button>
                            `}
                            <button class="footer-action secondary">
                                <i class="fas fa-envelope"></i> Contactar
                            </button>
                        </div>
                    </div>
                `;
                supplierPvs.insertAdjacentHTML('beforeend', cardHtml);
            }
        });

        // Re-attach event listeners for toggle buttons
        document.querySelectorAll('.toggle-history-btn').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const panel = document.getElementById(targetId);
                const isActive = panel.classList.contains('active');
                
                document.querySelectorAll('.history-panel').forEach(p => p.classList.remove('active'));
                document.querySelectorAll('.toggle-history-btn').forEach(b => b.classList.remove('active'));
                
                if (!isActive) {
                    panel.classList.add('active');
                    this.classList.add('active');
                }
            });
        });
    }

    // Function to filter PVs
  // Function to filter PVs and handle form display
function setupFilter() {
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', function () {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab styles
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards based on status
            document.querySelectorAll('.supplier-card').forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else {
                    card.style.display = card.getAttribute('data-status') === filter ? 'block' : 'none';
                }
            });

            // Handle form visibility
            if (filter === 'pending') {
                reviewForm.style.display = 'block'; // Show the review form for 'pending' status
            } else {
                reviewForm.style.display = 'none'; // Hide the review form for other statuses
            }
        });
    });
}

    // Load supplier data immediately
    renderPvs(testData.supplier, testData.pvs);
    setupFilter();
});
</script>
@endsection