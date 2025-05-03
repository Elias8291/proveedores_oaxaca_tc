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
                    <p class="page-subtitle">Gestión de renovaciones y estados de PVs para <span
                            id="supplier-name">Proveedor</span></p>
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
                <button class="tab-btn" data-status="renewal">
                    <span class="tab-icon"></span>
                    <span>Renovación</span>
                    <span class="tab-count" id="count-renewal">0</span>
                </button>
                <button class="tab-btn" data-filter="expired">
                    <span class="tab-icon"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="tab-text">Vencidos</span>
                    <span class="tab-count" id="count-expired">0</span>
                </button>
            </div>

            <!-- Sección de PVs del Proveedor -->
            <div class="supplier-pvs" id="supplier-pvs">
                <!-- Las tarjetas se generarán dinámicamente aquí -->
            </div>

            <!-- Formulario de revisión (fuera del contenedor de tarjetas) -->
            <div id="review-form" class="details-container">
                <a href="#" class="close-form-btn">&times; Cerrar</a>

                <!-- Todo el contenido de tu formulario aquí -->
                <form id="formulario1">
                    <!-- Sección para subir Constancia de Situación Fiscal -->
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
                                <p class="formulario__input-error">El RFC debe tener 12 o 13 caracteres alfanuméricos.
                                </p>
                            </div>
                        </div>
                        <!-- Campos visibles solo para revisor_1 -->
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--razon_social">
                                <label class="form-label" for="razon_social">Razón Social</label>
                                <input type="text" id="razon_social" name="razon_social" class="form-control"
                                    required maxlength="100" pattern="[A-Za-z\s&.,0-9]+">
                                <p class="formulario__input-error">La razón social debe contener solo letras, números,
                                    espacios y
                                    caracteres (&,.,).</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--correo_electronico">
                                <label class="form-label" for="correo_electronico Ebook gratuito">Correo
                                    Electrónico</label>
                                <input type="email" id="correo_electronico" name="correo_electronico"
                                    class="form-control" required>
                                <p class="formulario__input-error">El correo debe tener un formato válido (ej.
                                    usuario@dominio.com).
                                </p>
                            </div>
                        </div>
                        Affinity Designer <div class="form-group full-width" id="formulario__grupo--sectores">
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
                                <input type="tel" id="contacto_telefono" name="contacto_telefono"
                                    class="form-control" required pattern="[0-9]{10}">
                                <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos
                                    numéricos.</p>
                            </div>
                            <div class="half-width form-group" id="formulario__grupo--contacto_web">
                                <label class="form-label" for="contacto_web">Página Web (opcional)</label>
                                <input type="url" id="contacto_web" name="contacto_web" class="form-control"
                                    placeholder="https://www.ejemplo.com">
                                <p class="formulario__input-error">La URL debe ser válida (ej. https://www.empresa.com)
                                    o dejar en
                                    blanco.</p>
                            </div>
                        </div>
                        <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
                        <span>Persona encargada de recibir solicitudes y requerimientos</span>
                        <div class="form-group" id="formulario__grupo--contacto_nombre">
                            <label class="form-label" for="contacto_nombre">Nombre Completo</label>
                            <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control"
                                required maxlength="40" pattern="[A-Za-z\s]+">
                            <p class="formulario__input-error">El nombre debe contener solo letras y espacios, máximo
                                40 caracteres.
                            </p>
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
                            <p class="formulario__input-error">El teléfono debe contener exactamente 10 dígitos
                                numéricos.</p>
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
                                <p class="formulario__input-error">El estado debe contener solo letras y espacios,
                                    máximo 100 caracteres.</p>
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
                                <p class="formulario__input-error">Entre calle 1 debe contener letras, números o
                                    espacios, máximo 100 caracteres, o dejar en blanco.</p>
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
                                <p class="formulario__input-error">El número de escritura debe contener solo números
                                    (máx. 10 dígitos).</p>
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
                                <p class="formulario__input-error">El número de notario debe contener solo números
                                    (máx. 10 dígitos).</p>
                            </div>
                            <div class="half-width"></div> <!-- Espacio vacío para mantener el diseño -->
                        </div>
                        <h4><i class="fas fa-file-contract"></i> Datos de Inscripción en el Registro Público</h4>
                        <div class="form-group horizontal-group">
                            <div class="half-width form-group" id="formulario__grupo--numero_registro">
                                <label class="form-label" for="numero_registro">Número de Registro o Folio
                                    Mercantil</label>
                                <input type="text" id="numero_registro" name="numero_registro" class="form-control"
                                    placeholder="Ej: 987654">
                                <p class="formulario__input-error">El número de registro debe contener solo números
                                    (máx. 10 dígitos).</p>
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
                                        <input type="text" id="nombre-apoderado" name="nombre-apoderado"
                                            class="form-control" placeholder="Ej: Lic. Juan Pérez González">
                                        <p class="formulario__input-error">El nombre solo puede contener letras y
                                            espacios, máximo 100 caracteres.</p>
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
                                        <p class="formulario__input-error">El nombre del notario solo puede contener
                                            letras y espacios, máximo 100 caracteres.</p>
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
                                        <p class="formulario__input-error">Por favor, seleccione una entidad
                                            federativa.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--fecha-escritura">
                                        <label class="form-label" for="fecha-escritura">Fecha de Escritura</label>
                                        <input type="date" id="fecha-escritura" name="fecha-escritura"
                                            class="form-control">
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
                                        <label class="form-label" for="numero-registro">Número de Registro o Folio
                                            Mercantil</label>
                                        <input type="text" id="numero-registro" name="numero-registro"
                                            class="form-control" placeholder="Ej: 987654">
                                        <p class="formulario__input-error">El número de registro debe contener solo
                                            números, máximo 10 dígitos.</p>
                                    </div>
                                    <div class="half-width form-group" id="formulario__grupo--fecha-inscripcion">
                                        <label class="form-label" for="fecha-inscripcion">Fecha de Inscripción</label>
                                        <input type="date" id="fecha-inscripcion" name="fecha-inscripcion"
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
                                                <span class="file-description">Original, vigente, emitido por el SAT,
                                                    no mayor a 3 meses</span>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
                                        </div>

                                        <!-- Identificación Oficial -->
                                        <div class="file-item formulario__grupo" id="grupo__identificacion_oficial">
                                            <div class="file-icon">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Identificación Oficial</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original vigente (INE, pasaporte o
                                                    cédula profesional)</span>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
                                        </div>

                                        <!-- Curriculum Actualizado -->
                                        <div class="file-item formulario__grupo" id="grupo__curriculum">
                                            <div class="file-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Curriculum Actualizado</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, con giro, experiencia,
                                                    clientes y recursos</span>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
                                        </div>

                                        <!-- Croquis de Localización y Fotografías -->
                                        <div class="file-item formulario__grupo" id="grupo__croquis_fotografias">
                                            <div class="file-icon">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Croquis de Localización y Fotografías</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, del domicilio del
                                                    proveedor</span>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
                                        </div>

                                        <!-- Carta Poder Simple -->
                                        <div class="file-item formulario__grupo" id="grupo__carta_poder">
                                            <div class="file-icon">
                                                <i class="fas fa-file-contract"></i>
                                            </div>
                                            <div class="file-info">
                                                <h6>Carta Poder Simple</h6>
                                                <span class="file-type">PDF</span>
                                                <span class="file-description">Original, con identificación del
                                                    aceptante, si aplica</span>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
                                        </div>

                                        <!-- Acuse de Recibo -->
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
                                        </div>

                                        <!-- Poder Notariado -->
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
                                            <p class="formulario__input-error">Por favor suba un archivo PDF válido
                                                (máximo 10 MB).</p>
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
        /* Estilos para el formulario */
        #review-form {
            display: none;
            margin-top: 30px;
            padding: 25px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #review-form:target {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-form-btn {
            float: right;
            font-size: 1.5em;
            text-decoration: none;
            color: #718096;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .close-form-btn:hover {
            color: #2d3748;
            background-color: #f7fafc;
        }

        /* Asegurar que el botón sea clickeable */
        .footer-action.secondary {
            cursor: pointer;
            text-decoration: none;
        }

        /*css generales
            /* VARIABLES CSS GLOBALES */
            :root {
    /* Colores principales */
    --primary-color: #9D2449;
    --primary-dark: #7a1c38;
    --primary-light: #f8e8ee;
    --primary-ultra-light: #fcf5f7;

    /* Colores de estado */
    --success-color: #10b981;
    --success-light: #d1fae5;
    --success-dark: #059669;

    --warning-color: #f59e0b;
    --warning-light: #fef3c7;
    --warning-dark: #d97706;

    --danger-color: #f32727;
    --danger-light: #fee2e2;
    --danger-dark: #cc1717;

    /* Colores neutros */
    --text-dark: #374151;
    --text-medium: #6b7280;
    --text-light: #9ca3af;

    --bg-light: #f9fafb;
    --bg-subtle: #f3f4f6;
    --border-light: #e5e7eb;
    --border-medium: #d1d5db;

    /* Sombras */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-glow:  Ascendingly: 0 0 15px rgba(157, 36, 73, 0.15);

    /* Tipografía */
    --font-primary: 'Inter', 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;

    /* Radios de borde */
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 16px;
    --radius-full: 9999px;

    /* Transiciones */
    --transition-fast: 0.2s ease;
    --transition-normal: 0.3s ease;
}

/* ESTILOS BASE */
body {
    background-color: var(--bg-light);
    color: var(--text-dark);
    font-family: var(--font-primary);
    line-height: 1.5;
    margin: 0;
    padding: 0;
}

/* CONTENEDOR PRINCIPAL */
.content-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 32px 24px;
}

/* ENCABEZADO DE PÁGINA */
.page-header {
    margin-bottom: 36px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
    letter-spacing: -0.025em;
}

.page-subtitle {
    color: var(--text-medium);
    font-size: 16px;
    margin: 0;
    font-weight: 400;
}

.header-logo {
    width: 140px;
    height: auto;
    margin-left: 24px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
}

/* TARJETAS DE PROVEEDOR */
.supplier-pvs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 28px;
    margin-bottom: 48px;
}

.supplier-card {
    background-color: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
    border: 1px solid var(--border-light);
    display: flex;
    flex-direction: column;
    position: relative;
    height: 100%;
}

.supplier-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-medium);
}

/* Estilo visual para tarjetas expiradas (solo apariencia) */
.supplier-card.expired {
    background-color: var(--bg-subtle);
    border-color: var(--border-medium);
    position: relative;
}

.supplier-card.expired::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(200, 200, 200, 0.2);
    border-radius: var(--radius-lg);
    z-index: 5;
}

/* ENCABEZADO DE TARJETA */
.card-header {
    display: flex;
    padding: 50px 24px 22px;
    gap: 20px;
    border-bottom: 1px solid var(--border-light);
    position: relative;
    background: linear-gradient(180deg, rgba(252, 245, 247, 0.8) 0%, rgba(255, 255, 255, 0) 100%);
}

.supplier-card.expired .card-header {
    background: linear-gradient(180deg, rgba(243, 244, 246, 0.8) 0%, rgba(255, 255, 255, 0) 100%);
}
/* Estado expirado - más destacado */
.supplier-card.expired .status-pill.expired {
    background-color: var(--danger-light);
    color: var(--danger-dark);
    border: 1px solid var(--danger-color);
    z-index: 10;
}

.supplier-logo {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 22px;
    flex-shrink: 0;
    color: white;
    margin-left: auto;
    order: 2;
    box-shadow: var(--shadow-md);
    background-size: 150% 150%;
    animation: gradientAnimation 3s ease infinite;
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.supplier-logo.active {
    background: linear-gradient(135deg, var(--success-dark) 0%, var(--success-color) 100%);
}

.supplier-logo.expired {
    background: linear-gradient(135deg, var(--danger-dark) 0%, var(--danger-color) 100%);
}

.supplier-logo.pending {
    background: linear-gradient(135deg, var(--warning-dark) 0%, var(--warning-color) 100%);
}

.supplier-info {
    flex: 1;
    min-width: 0;
}
.expired-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    margin: 0 24px 16px;
    background-color: var(--danger-light);
    color: var(--danger-dark);
    border-radius: var(--radius-md);
    border-left: 4px solid var(--danger-color);
    font-weight: 600;
    font-size: 14px;
}

.expired-alert i {
    font-size: 18px;
}
.supplier-card.expired .supplier-info {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.supplier-info h3 {
    margin: 0 0 8px 0;
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: -0.01em;
}

.supplier-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 14px;
    color: var(--text-medium);
    justify-content: center;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.meta-item i {
    color: var(--text-light);
    font-size: 16px;
}

/* POSICIONAMIENTO DEL ESTADO */
.supplier-status {
    position: absolute;
    top: 2px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

/* ETIQUETAS DE ESTADO */
.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 7px 18px;
    border-radius: var(--radius-full);
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: var(--shadow-md);
    transition: transform var(--transition-fast);
    position: relative;
}

.status-pill:hover {
    transform: translateY(-2px);
}

.status-pill::before {
    content: "";
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
    animation: pulseAnimation 2s infinite;
}

@keyframes pulseAnimation {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.2);
    }

    70% {
        box-shadow: 0 0 0 6px rgba(0, 0, 0, 0);
    }

    100% {
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
    }
}

.status-pill.active {
    background-color: var(--success-light);
    color: var(--success-dark);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-pill.active::before {
    background-color: var(--success-color);
}

.status-pill.expired {
    background-color: var(--danger-light);
    color: var(--danger-dark);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.status-pill.expired::before {
    background-color: var(--danger-color);
}

.status-pill.pending {
    background-color: var(--warning-light);
    color: var(--warning-dark);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-pill.pending::before {
    background-color: var(--warning-color);
}

.status-pill[title]:hover:after {
    content: attr(title);
    position: absolute;
    top: -38px;
    left: 50%;
    transform: translateX(-50%);
    background-color: var(--text-dark);
    color: white;
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    font-size: 12px;
    white-space: nowrap;
    z-index: 20;
    box-shadow: var(--shadow-md);
}

/* CUERPO DE TARJETA */
.card-body {
    padding: 24px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Contenido de tarjeta expirada */
.supplier-card.expired .card-body {
    position: relative; /* Para asegurar que el contenido sea interactivo */
}
.supplier-card.expired .progress-bar {
    background: linear-gradient(90deg, #9ca3af 0%, #6b7280 100%);
}/* Textos en tarjeta expirada */
.supplier-card.expired .info-value:not(.expired) {
    color: var(--text-medium);
}

.supplier-card.expired .info-label {
    color: var(--text-light);
}

/* Elementos que deben mantenerse visibles */
.supplier-card.expired .info-value.expired {
    color: var(--danger-dark);
    font-weight: 600;
    text-decoration: line-through;
}

/* Sección de historial - siempre funcional */
.history-toggle {
    position: relative; /* Asegura que esté sobre el overlay */
    z-index: 10;
}

.history-panel {
    position: relative;
    z-index: 10;
    background-color: white;
}

/* Efecto hover para tarjetas expiradas */
.supplier-card.expired:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

/* Ajustes para el logo en estado expirado */
.supplier-card.expired .supplier-logo {
    filter: grayscale(30%);
    opacity: 0.9;
}

/* Botones en tarjetas expiradas */
.supplier-card.expired .footer-action {
    position: relative;
    z-index: 10;
}

/* Timeline en tarjetas expiradas */
.supplier-card.expired .timeline {
    background-color: white;
    border-radius: var(--radius-md);
    margin-top: 16px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(180px, 1fr));
    grid-template-areas: 
        "vigencia contacto"
        "telefono telefono";
    gap: 24px;
    margin-bottom: 24px;
}

.info-item.vigencia {
    grid-area: vigencia;
}

.info-item.contacto {
    grid-area: contacto;
}

.info-item.telefono {
    grid-area: telefono;
    justify-content: center;
}

.info-item {
    display: flex;
    gap: 14px;
}

.info-item i {
    color: var(--primary-color);
    font-size: 20px;
    margin-top: 3px;
    opacity: 0.85;
}

.info-content {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 14px;
    color: var(--text-light);
    margin-bottom: 6px;
    font-weight: 500;
}

.info-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark);
}

/* VALORES EXPIRADOS */
.info-value.expired,
.info-label.expired {
    color: var(--danger-color);
    opacity: 1;
    text-decoration: line-through;
}

/* BARRA DE PROGRESO */
.progress-container {
    margin-top: 24px;
    margin-bottom: 8px;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: var(--text-medium);
    font-weight: 500;
}

.progress-bar-container {
    height: 10px;
    background-color: var(--bg-subtle);
    border-radius: var(--radius-full);
    overflow: hidden;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}

.progress-bar {
    height: 100%;
    border-radius: var(--radius-full);
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.progress-bar.active {
    background: linear-gradient(90deg, var(--success-color) 0%, var(--success-dark) 100%);
}

.progress-bar.pending {
    background: linear-gradient(90deg, var(--warning-color) 0%, var(--warning-dark) 100%);
}

.progress-bar.expired {
    background: linear-gradient(90deg, #9ca3af 0%, #6b7280 100%);
}

.progress-bar::after {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 加0, 0.3) 50%,
            rgba(255, 255, 255, 0) 100%);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% {
        left: -100%;
    }

    100% {
        left: 100%;
    }
}
        /* ALERTAS DE ESTADO */
        .status-warning {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 500;
            margin-top: 24px;
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border-left: 4px solid var(--danger-color);
        }

        .status-warning i {
            font-size: 20px;
            margin-top: 2px;
        }

        /* TOGGLE DE HISTORIAL */
        .history-toggle {
            padding: 0 24px;
            border-top: 1px solid var(--border-light);
            margin-top: auto;
        }

        .toggle-history-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 0;
            border: none;
            background-color: transparent;
            color: var(--text-medium);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .toggle-history-btn:hover {
            color: var(--primary-color);
        }

        .toggle-history-btn i {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 16px;
        }

        .toggle-history-btn.active i {
            transform: rotate(180deg);
        }

        /* PANEL DE HISTORIAL */
        .history-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
        }

        .history-panel.active {
            max-height: 2000px;
            transition: max-height 1s ease-in-out;
        }

        /* TIMELINE */
        .timeline {
            position: relative;
            padding: 24px;
            padding-left: 44px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 34px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--border-medium);
        }

        .timeline-item {
            display: flex;
            gap: 18px;
            margin-bottom: 28px;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: relative;
            z-index: 1;
            margin-left: -44px;
        }

        .year-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            color: white;
            box-shadow: var(--shadow-md);
        }

        .timeline-item.current .year-badge {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            animation: pulseGlow 2s infinite alternate;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 5px rgba(157, 36, 73, 0.4);
            }

            100% {
                box-shadow: 0 0 20px rgba(157, 36, 73, 0.7);
            }
        }

        .timeline-item.completed .year-badge {
            background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
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
            gap: 14px;
            margin-bottom: 18px;
        }

        .period-label {
            font-size: 16px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .period-status {
            display: flex;
            gap: 10px;
        }

        .timeline-details {
            background-color: white;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-light);
            overflow: hidden;
            margin-bottom: 18px;
            box-shadow: var(--shadow-sm);
        }

        .detail-row {
            display: grid;
            grid-template-columns: 30px auto 1fr;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--bg-subtle);
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-icon {
            color: var(--primary-color);
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
        }

        .detail-label {
            font-size: 14px;
            color: var(--text-light);
            white-space: nowrap;
        }

        .detail-value {
            font-size: 15px;
            color: var(--text-dark);
            font-weight: 500;
            word-break: break-word;
        }

        /* ACCIONES DEL TIMELINE */
        .timeline-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        /* BOTONES DE ESTADO (TABS) - Mismo color */
.status-tabs {
    display: flex;
    justify-content: center; /* Centrado horizontal */
    gap: 12px;
    margin-bottom: 36px;
    padding-bottom: 10px;
    overflow-x: auto;
}

.tab-btn {
    display: flex;
    align-items: center;
    justify-content: center; /* Centrado interno */
    gap: 10px;
    padding: 12px 20px;
    background-color: white;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    font-size: 15px;
    font-weight: 500;
    color: var(--text-medium);
    cursor: pointer;
    transition: all var(--transition-normal);
    white-space: nowrap;
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
    min-width: 120px; /* Ancho mínimo consistente */
    text-align: center;
}

.tab-btn.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-dark);
    box-shadow: 0 4px 12px rgba(157, 36, 73, 0.2);
    font-weight: 600;
}

.tab-btn:hover:not(.active) {
    background-color: var(--primary-ultra-light);
    border-color: var(--primary-light);
    color: var(--primary-color);
}

/* BOTONES DE ACCIÓN - Mismo color */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 10px 18px;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-normal);
    border: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    background-color: var(--primary-color);
    color: white;
    min-width: 120px;
}

.action-btn:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(157, 36, 73, 0.2);
}

/* Iconos para botones de acción */
.action-btn i {
    font-size: 16px;
}

.action-btn.view i::before {
    content: "\f06e"; /* eye */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}

.action-btn.approve i::before {
    content: "\f00c"; /* check */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}

.action-btn.request i::before {
    content: "\f071"; /* exclamation */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}

/* BOTONES DE PIE DE TARJETA - Mismo color */
.card-footer {
    display: flex;
    justify-content: center; /* Centrado horizontal */
    gap: 14px;
    padding: 18px 24px;
    border-top: 1px solid var(--border-light);
    background-color: var(--bg-subtle);
}

.footer-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 24px;
    border-radius: var(--radius-md);
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-normal);
    min-width: 150px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.footer-action:hover {
    background-color: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(157, 36, 73, 0.2);
}

/* Iconos para botones de pie */
.footer-action.primary i::before {
    content: "\f0a1"; /* bolt */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}

.footer-action.secondary {
    background-color: white;
    color: var(--primary-color);
    border: 1px solid var(--primary-light);
}

.footer-action.secondary:hover {
    background-color: var(--primary-ultra-light);
    color: var(--primary-dark);
}

.footer-action.secondary i::before {
    content: "\f05a"; /* info */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}
        /* ALERTAS */
        .alert {
            padding: 18px;
            border-radius: var(--radius-md);
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            font-size: 15px;
            line-height: 1.6;
        }

        .alert i {
            font-size: 22px;
            margin-top: 2px;
        }

        .alert-info {
            background-color: #e0f2fe;
            color: #0369a1;
            border-left: 4px solid #0ea5e9;
        }

        .alert-danger {
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border-left: 4px solid var(--danger-color);
        }

        /* FORMULARIO DE REVISIÓN */
        .review-form-container {
            background-color: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            padding: 28px;
            margin-top: 28px;
            box-shadow: var(--shadow-md);
        }

        .form-section {
            margin-bottom: 36px;
        }

        .form-section h4 {
            font-size: 20px;
            color: var(--text-dark);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
        }

        .form-section h4 i {
            color: var(--primary-color);
            opacity: 0.8;
        }

        /* Estilos para estado "Renovación" */
.status-pill.renewal {
    background-color: var(--warning-light);
    color: var(--warning-dark);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-pill.renewal::before {
    background-color: var(--warning-color);
}

.supplier-logo.renewal {
    background: linear-gradient(135deg, var(--warning-dark) 0%, var(--warning-color) 100%);
}

.progress-bar.renewal {
    background: linear-gradient(90deg, var(--warning-color) 0%, var(--warning-dark) 100%);
}

.renewal-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    margin: 0 24px 16px;
    background-color: var(--warning-light);
    color: var(--warning-dark);
    border-radius: var(--radius-md);
    border-left: 4px solid var(--warning-color);
    font-weight: 600;
    font-size: 14px;
}

.renewal-alert i {
    font-size: 18px;
}
        /* DISEÑO RESPONSIVO */
        @media (max-width: 1200px) {
            .supplier-pvs {
                grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .supplier-pvs {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }

            .content-wrapper {
                padding: 24px 20px;
            }
        }

        @media (max-width: 768px) {
            .supplier-pvs {
                grid-template-columns: 1fr;
            }

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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .header-logo {
                margin-left: 0;
                margin-top: 16px;
            }

            .page-title {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .content-wrapper {
                padding: 20px 16px;
            }

            .page-title {
                font-size: 24px;
            }

            .page-subtitle {
                font-size: 14px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .supplier-meta {
                flex-direction: column;
                gap: 10px;
            }

            .timeline-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .detail-row {
                grid-template-columns: 30px 1fr;
            }

            .detail-label {
                grid-column: 2;
            }

            .detail-value {
                grid-column: 2;
                margin-top: 4px;
            }

            .status-tabs {
                gap: 10px;
            }

            .tab-btn {
                padding: 10px 16px;
                font-size: 14px;
            }

            .tab-count {
                min-width: 20px;
                height: 20px;
                font-size: 12px;
            }

            .card-header {
                padding: 40px 18px 18px;
            }

            .supplier-logo {
                width: 52px;
                height: 52px;
                font-size: 18px;
            }
        }
    </style>

    <script>
        // Datos de prueba
        const testData = {
            supplier: {
                name: "TECNOLOGÍA AVANZADA S.A. DE C.V.",
                rfc: "TAA250101ABC",
                contact_name: "Ing. Laura Méndez",
                phone: "55 1234 5678"
            },
            pvs: [{
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
                },
                {
      pv_id: "PV-002",
      status: "renewal",  // <- Ejemplo de PV en renovación
      start_date: "01/01/2022",
      end_date: "31/12/2022",
      registration_date: "15/12/2021",
      responsible_person: "Carlos López",
      observations: "En proceso de renovación"
    }
  ]
};

        document.addEventListener('DOMContentLoaded', function() {
    const supplierName = document.getElementById('supplier-name');
    const supplierPvs = document.getElementById('supplier-pvs');
    const alertContainer = document.getElementById('alert-container');
    const countAll = document.getElementById('count-all');
    const countActive = document.getElementById('count-active');
    const countRenewal = document.getElementById('count-renewal');
    const countExpired = document.getElementById('count-expired');
    const reviewForm = document.getElementById('review-form');

    // Función para renderizar alertas
    function renderAlert(message, type = 'info') {
        alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    }

    // Función para renderizar tarjetas de PVs
    function renderPvs(supplier, pvs) {
        supplierPvs.innerHTML = '';
        supplierName.textContent = supplier.name;

        // Actualizar contadores de pestañas
        const activeCount = pvs.filter(pv => pv.status === 'active').length;
        const renewalCount = pvs.filter(pv => pv.status === 'renewal').length;
        const expiredCount = pvs.filter(pv => pv.status === 'expired').length;
        
        countAll.textContent = pvs.length;
        countActive.textContent = activeCount;
        countRenewal.textContent = renewalCount;
        countExpired.textContent = expiredCount;

        if (pvs.length === 0) {
            supplierPvs.innerHTML =
                '<div class="alert alert-info">No se encontraron PVs para este proveedor.</div>';
            return;
        }

        pvs.forEach((pv, index) => {
            // Determinar el texto del estado
            let statusText = '';
            let statusTitle = '';
            switch(pv.status) {
                case 'active':
                    statusText = 'Activo';
                    statusTitle = 'PV vigente hasta ' + pv.end_date;
                    break;
                case 'expired':
                    statusText = 'Expirado';
                    statusTitle = 'PV expirado el ' + pv.end_date;
                    break;
                case 'renewal':
                    statusText = 'Renovación';
                    statusTitle = 'PV en proceso de renovación';
                    break;
            }

            const cardHtml = `
            <div class="supplier-card ${pv.status}" data-status="${pv.status}">
                <div class="card-header">
                    <div class="supplier-info">
                        <h3>${supplier.name}</h3>
                        <div class="supplier-meta">
                            <span class="meta-item"><i class="fas fa-id-card"></i> ${pv.pv_id}</span>
                            <span class="meta-item"><i class="fas fa-file-invoice"></i> RFC: ${supplier.rfc}</span>
                        </div>
                    </div>
                    <div class="header-status-logo">
                        <div class="supplier-status">
                            <span class="status-pill ${pv.status}" title="${statusTitle}">
                                ${statusText}
                            </span>
                        </div>
                        <div class="supplier-logo ${pv.status}">
                            <span>${supplier.name.substring(0, 2).toUpperCase()}</span>
                        </div>
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
                        <div class="expired-alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Registro vencido - Se requiere crear nuevo PV</span>
                        </div>
                    ` : ''}
                    ${pv.status === 'renewal' ? `
                        <div class="renewal-alert">
                            <i class="fas fa-sync-alt"></i>
                            <span>PV en proceso de renovación</span>
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
                        <div class="timeline-item ${pv.status === 'active' || pv.status === 'renewal' ? 'current' : 'completed'}">
                            <div class="timeline-marker">
                                <span class="year-badge">${new Date(pv.end_date.split('/')[2]).getFullYear()}</span>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <div class="period-label">${pv.start_date} - ${pv.end_date}</div>
                                    <div class="period-status">
                                        <span class="status-pill ${pv.status}">${statusText}</span>
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
                                    ${pv.status === 'renewal' ? `
                                        <div class="detail-row">
                                            <div class="detail-icon"><i class="fas fa-clock"></i></div>
                                            <div class="detail-label">Estado Renovación:</div>
                                            <div class="detail-value">En proceso</div>
                                        </div>
                                    ` : ''}
                                </div>
                                <div class="timeline-actions">
                                    ${pv.status === 'renewal' ? `
                                        <button class="action-btn approve">
                                            <i class="fas fa-check"></i> Completar Renovación
                                        </button>
                                        <button class="action-btn request">
                                            <i class="fas fa-paperclip"></i> Subir Documentos
                                        </button>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    ${pv.status === 'expired' ? ` 
                        <button class="footer-action primary">
                            <i class="fas fa-file-alt"></i> Crear Nuevo PV
                        </button>
                    ` : `
                        <button class="footer-action primary">
                            <i class="fas fa-file-alt"></i> Ver Detalles Completos
                        </button>
                        ${pv.status === 'renewal' ? `
                            <button class="footer-action secondary">
                                <i class="fas fa-envelope"></i> Contactar Proveedor
                            </button>
                        ` : `
                            <a href="#review-form" class="footer-action secondary">
                                <i class="fas fa-envelope"></i> Iniciar revisión
                            </a>
                        `}
                    `}
                </div>
            </div>
            `;
            supplierPvs.insertAdjacentHTML('beforeend', cardHtml);
        });

        // Re-attach event listeners for toggle buttons
        document.querySelectorAll('.toggle-history-btn').forEach(button => {
            button.addEventListener('click', function() {
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
    function setupFilter() {
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', function() {
                const status = this.getAttribute('data-status');

                // Update active tab styles
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter cards based on status
                document.querySelectorAll('.supplier-card').forEach(card => {
                    if (status === 'all') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = card.getAttribute('data-status') === status ? 'block' : 'none';
                    }
                });
            });
        });
    }

    // Load supplier data immediately
    renderPvs(testData.supplier, testData.pvs);
    setupFilter();
});
    </script>
@endsection
