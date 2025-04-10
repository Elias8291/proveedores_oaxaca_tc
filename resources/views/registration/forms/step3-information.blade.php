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
                </div>
            
                <!-- Nombre del Notario -->
                <div class="half-width">
                    <label class="form-label" for="nombre_notario">Nombre del Notario</label>
                    <input type="text" id="nombre_notario" name="nombre_notario" class="form-control" placeholder="Ej: Lic. Juan Pérez González">
                </div>
            </div>
            <div class="form-group horizontal-group" style="display: flex; justify-content: space-between; gap: 15px;">
                <!-- Entidad Federativa -->
                <div style="flex: 1;">
                    <label class="form-label" for="entidad_federativa">Entidad Federativa</label>
                    <input type="text" id="entidad_federativa" name="entidad_federativa" class="form-control" 
                           placeholder="Ej: Ciudad de México" style="width: 100%;">
                </div>
            
                <!-- Fecha de Constitución -->
                <div style="flex: 1;">
                    <label class="form-label" for="fecha_constitucion">Fecha de Constitución</label>
                    <input type="date" id="fecha_constitucion" name="fecha_constitucion" 
                           class="form-control" style="width: 100%;">
                </div>
            
                <!-- Número de Notario -->
                <div style="flex: 1;">
                    <label class="form-label" for="numero_notario">Número de Notario</label>
                    <input type="text" id="numero_notario" name="numero_notario" class="form-control" 
                           placeholder="Ej: 123" style="width: 100%;">
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
                </div>
            
                <!-- Fecha de Inscripción -->
                <div class="half-width">
                    <label class="form-label" for="fecha_inscripcion">Fecha de Inscripción</label>
                    <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>