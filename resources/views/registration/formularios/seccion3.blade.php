<form id="formulario3">

    <div class="form-section" id="form-step-3">
        <div class="form-container">
            <div class="form-column">
                <div class="form-group">
                    <h4><i class="fas fa-building"></i> Datos de Constitución (Persona Moral)</h4>
                </div>
                <div class="form-group horizontal-group">
                    <!-- Número de Escritura -->
                    <div class="half-width">
                        <label class="form-label" for="numero_escritura">Número de Escritura</label>
                        <input type="text" id="numero_escritura" name="numero_escritura" class="form-control" placeholder="Ej: 12345">
                        <p class="formulario__input-error">El número de escritura debe contener solo números (máx. 10 dígitos).</p>
                    </div>
                    <!-- Nombre del Notario -->
                    <div class="half-width">
                        <label class="form-label" for="nombre_notario">Nombre del Notario</label>
                        <input type="text" id="nombre_notario" name="nombre_notario" class="form-control" placeholder="Ej: Lic. Juan Pérez González">
                        <p class="formulario__input-error">El nombre del notario debe contener solo letras y espacios (máx. 100 caracteres).</p>
                    </div>
                </div>
                <div class="form-group horizontal-group" style="display: flex; justify-content: space-between; gap: 15px;">
                    <!-- Entidad Federativa -->
                    <div style="flex: 1;">
                        <label class="form-label" for="entidad_federativa">Entidad Federativa</label>
                        <input type="text" id="entidad_federativa" name="entidad_federativa" class="form-control" placeholder="Ej: Ciudad de México">
                        <p class="formulario__input-error">La entidad federativa debe contener solo letras y espacios (máx. 50 caracteres).</p>
                    </div>
                    <!-- Fecha de Constitución -->
                    <div style="flex: 1;">
                        <label class="form-label" for="fecha_constitucion">Fecha de Constitución</label>
                        <input type="date" id="fecha_constitucion" name="fecha_constitucion" class="form-control">
                        <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                    </div>
                    <!-- Número de Notario -->
                    <div style="flex: 1;">
                        <label class="form-label" for="numero_notario">Número de Notario</label>
                        <input type="text" id="numero_notario" name="numero_notario" class="form-control" placeholder="Ej: 123">
                        <p class="formulario__input-error">El número de notario debe contener solo números (máx. 10 dígitos).</p>
                    </div>
                </div>          
                <div class="form-group">
                    <h4><i class="fas fa-file-contract"></i> Datos de Inscripción en el Registro Público</h4>
                </div>
                <div class="form-group horizontal-group">
                    <!-- Número de Registro o Folio Mercantil -->
                    <div class="half-width">
                        <label class="form-label" for="numero_registro">Número de Registro o Folio Mercantil</label>
                        <input type="text" id="numero_registro" name="numero_registro" class="form-control" placeholder="Ej: 987654">
                        <p class="formulario__input-error">El número de registro debe contener solo números (máx. 10 dígitos).</p>
                    </div>
                    <!-- Fecha de Inscripción -->
                    <div class="half-width">
                        <label class="form-label" for="fecha_inscripcion">Fecha de Inscripción</label>
                        <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" class="form-control">
                        <p class="formulario__input-error">Por favor, seleccione una fecha válida.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>