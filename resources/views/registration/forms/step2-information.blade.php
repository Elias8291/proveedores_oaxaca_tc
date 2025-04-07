<div class="form-section" id="form-step-2">
    <div class="form-container">
        <!-- Primera columna -->
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-map-marker-alt"></i> Domicilio</h4>
            </div>
            <div class="form-group">
                <label class="form-label" for="codigo_postal">Código Postal</label>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" placeholder="Ej: 68000">
                <p class="formulario__input-error">El código postal debe contener 5 dígitos.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="estado">Estado</label>
                <input type="text" id="estado" name="estado" class="form-control" placeholder="Ej: Oaxaca">
                <p class="formulario__input-error">Este campo es obligatorio.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="municipio">Municipio</label>
                <input type="text" id="municipio" name="municipio" class="form-control" placeholder="Ej: Oaxaca de Juárez">
                <p class="formulario__input-error">Este campo es obligatorio.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="colonia">Asentamiento</label>
                <select id="colonia" name="colonia" class="form-control">
                    <option value="">Seleccione un Asentamiento</option>
                </select>
                <p class="formulario__input-error">Debes seleccionar un asentamiento.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="calle">Calle</label>
                <input type="text" id="calle" name="calle" class="form-control" placeholder="Ej: Av. Principal">
                <p class="formulario__input-error">Este campo es obligatorio.</p>
            </div>
            <!-- Número Exterior y Número Interior en la misma fila -->
            <div class="form-group form-row">
                <div class="form-group-inline">
                    <label class="form-label" for="numero_exterior">Número Exterior</label>
                    <input type="text" id="numero_exterior" name="numero_exterior" class="form-control" placeholder="Ej: 123">
                    <p class="formulario__input-error">Este campo es obligatorio.</p>
                </div>
                <div class="form-group-inline">
                    <label class="form-label" for="numero_interior">Número Interior</label>
                    <input type="text" id="numero_interior" name="numero_interior" class="form-control" placeholder="Ej: 5A">
                    <p class="formulario__input-error">Este campo es opcional.</p>
                </div>
            </div>
        </div>

        <!-- Segunda columna -->
        <div class="form-column">
            <div class="form-group">
                <label class="form-label" for="entre_calle_1">Entre Calle 1</label>
                <input type="text" id="entre_calle_1" name="entre_calle_1" class="form-control" placeholder="Ej: Calle Independencia">
            </div>
            <div class="form-group">
                <label class="form-label" for="entre_calle_2">Entre Calle 2</label>
                <input type="text" id="entre_calle_2" name="entre_calle_2" class="form-control" placeholder="Ej: Calle Morelos">
            </div>
            <div class="form-group map-section">
                <h4><i class="fas fa-map"></i> Ubicación en Mapa</h4>
                <p class="map-instructions">Al colocar los datos, la dirección se ubica automáticamente.</p>
                <div id="map" style="height: 250px; width: 100%; margin-top: 15px; border-radius: 8px;"></div>
            </div>
        </div>
    </div>
</div>