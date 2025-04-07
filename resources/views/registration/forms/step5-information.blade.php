<div id="section-5" class="form-section" >
    <div class="form-container">
        <!-- Primera columna -->
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-user-tie"></i> Datos del Apoderado o Representante Legal</h4>
            </div>
            <div class="form-group">
                <label class="form-label" for="nombre-apoderado">Nombre</label>
                <input type="text" id="nombre-apoderado" name="nombre-apoderado" class="form-control" placeholder="Nombre completo del apoderado o representante legal">
            </div>
            <div class="form-group">
                <label class="form-label" for="numero-escritura">Número de Escritura</label>
                <input type="text" id="numero-escritura" name="numero-escritura" class="form-control" placeholder="Número de escritura">
            </div>
            <div class="form-group">
                <label class="form-label" for="nombre-notario">Nombre del Notario</label>
                <input type="text" id="nombre-notario" name="nombre-notario" class="form-control" placeholder="Nombre del notario">
            </div>
            <!-- Número del Notario, Entidad Federativa y Fecha en la misma fila -->
            <div class="form-group form-row">
                <div class="form-group-inline">
                    <label class="form-label" for="numero-notario">Número del Notario</label>
                    <input type="text" id="numero-notario" name="numero-notario" class="form-control" placeholder="Número del notario">
                </div>
                <div class="form-group-inline">
                    <label class="form-label" for="entidad-federativa">Entidad Federativa</label>
                    <input type="text" id="entidad-federativa" name="entidad-federativa" class="form-control" placeholder="Entidad federativa">
                </div>
                <div class="form-group-inline">
                    <label class="form-label" for="fecha-escritura">Fecha</label>
                    <input type="date" id="fecha-escritura" name="fecha-escritura" class="form-control">
                </div>
            </div>
        </div>

        <!-- Segunda columna -->
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-book"></i> Datos de Inscripción en el Registro Público</h4>
            </div>
            <div class="form-group">
                <label class="form-label" for="numero-registro">Número de Registro o Folio Mercantil</label>
                <input type="text" id="numero-registro" name="numero-registro" class="form-control" placeholder="Número de registro o folio mercantil">
            </div>
            <div class="form-group">
                <label class="form-label" for="fecha-inscripcion">Fecha de Inscripción</label>
                <input type="date" id="fecha-inscripcion" name="fecha-inscripcion" class="form-control">
            </div>
        </div>
    </div>
</div>