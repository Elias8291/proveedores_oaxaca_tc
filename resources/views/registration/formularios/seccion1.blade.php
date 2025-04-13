<!-- resources/views/registration/forms/step1-information.blade.php -->
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

        <div class="form-group full-width" id="formulario__grupo--actividad_comercial">
            <label class="form-label">Actividades Comerciales</label>
            <select name="actividad_comercial" id="actividad_comercial" class="form-control">
                <option value="">Seleccione una actividad</option>
                <option value="1">Actividad 1</option>
                <option value="2">Actividad 2</option>
                <option value="3">Actividad 3</option>
            </select>
            <p class="formulario__input-error">Debe seleccionar al menos una actividad comercial.</p>
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