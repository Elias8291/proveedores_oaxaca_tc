<div class="form-section" id="form-step-1" >
    <div class="form-container">
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-building"></i> Datos Generales</h4>
            </div>
            <div class="form-group custom-select">
                <label class="form-label" for="sector">Sector al que Pertenece *</label>
                <select id="sector" name="sector" class="form-control" required>
                    <option value="">Seleccione un sector</option>
                    <!-- Las opciones de sector se deben agregar manualmente aquí -->
                </select>
                <p class="formulario__input-error">Debes seleccionar un sector.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="actividad_comercial">Actividades Comerciales *</label>
                <select id="actividad_comercial" name="actividad_comercial" class="form-control" required>
                    <option value="">Seleccione una actividad</option>
                    <!-- Las opciones de actividades comerciales se deben agregar manualmente aquí -->
                </select>
                <p class="formulario__input-error">Debes seleccionar una actividad comercial.</p>
            </div>
            <div class="form-group full-width actividades-contenedor">
                <div class="actividades-header">
                    <i class="fas fa-list-check"></i> Actividades Seleccionadas
                </div>
                <div id="actividades_seleccionadas" class="actividades-lista">
                    <div class="empty-message">No hay actividades seleccionadas</div>
                </div>
                <input type="hidden" name="actividades_comerciales" id="actividades_comerciales_input">
            </div>
            <div class="form-group">
                <label class="form-label" for="curp">CURP (Solo si es persona física)</label>
                <input type="text" id="curp" name="curp" class="form-control" placeholder="Ej: ABCD123456HDFXYZ01" maxlength="18">
                <p class="formulario__input-error">El CURP no tiene un formato válido.</p>
            </div>
        </div>

        <!-- Columna 2: Datos de Contacto -->
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-address-card"></i> Datos de Contacto</h4>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_nombre">Nombre Completo *</label>
                <input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control" placeholder="Ej: Juan Pérez González" required>
                <p class="formulario__input-error">El nombre debe contener solo letras y espacios.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_cargo">Cargo o Puesto *</label>
                <input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control" placeholder="Ej: Director General" required>
                <p class="formulario__input-error">Este campo es obligatorio.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_telefono">Teléfono de Contacto *</label>
                <input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control" placeholder="Ej: (951) 145 45 25" required>
                <p class="formulario__input-error">El teléfono debe contener entre 7 y 14 números.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_correo">Correo Electrónico *</label>
                <input type="email" id="contacto_correo" name="contacto_correo" class="form-control" placeholder="Ej: contacto@empresa.com" required>
                <p class="formulario__input-error">El correo electrónico no es válido.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="contacto_web">Página Web</label>
                <input type="url" id="contacto_web" name="contacto_web" class="form-control" placeholder="Ej: https://www.empresa.com">
                <p class="formulario__input-error">La URL no es válida.</p>
            </div>
        </div>
        
    </div>
</div>