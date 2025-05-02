@extends('dashboard')

@section('title', 'Detalles de Solicitud')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="dashboard-container">
    <div class="content-wrapper">
        <h1 class="page-title">Detalles de Solicitud</h1>
        <p class="page-subtitle">Revisa los detalles de la solicitud</p>

        <!-- Mostrar mensaje de error si existe -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Detalles del solicitante -->
        <div class="details-container">
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
@endsection