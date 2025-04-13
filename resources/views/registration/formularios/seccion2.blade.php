<form id="formulario2">
    <div class="form-section" id="form-step-2">
        <h4><i class="fas fa-map-marker-alt"></i> Domicilio</h4>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--codigo_postal">
                <label class="form-label" for="codigo_postal">Código Postal</label>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" placeholder="Ej: 68000">
                <p class="formulario__input-error">El código postal debe contener 5 dígitos.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--estado">
                <label class="form-label" for="estado">Estado</label>
                <input type="text" id="estado" name="estado" class="form-control" placeholder="Ej: Oaxaca">
                <p class="formulario__input-error">El estado debe contener solo letras y espacios, máximo 50 caracteres.</p>
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--municipio">
                <label class="form-label" for="municipio">Municipio</label>
                <input type="text" id="municipio" name="municipio" class="form-control" placeholder="Ej: Oaxaca de Juárez">
                <p class="formulario__input-error">El municipio debe contener solo letras y espacios, máximo 100 caracteres.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--colonia">
                <label class="form-label" for="colonia">Asentamiento</label>
                <select id="colonia" name="colonia" class="form-control">
                    <option value="">Seleccione un Asentamiento</option>
                </select>
                <p class="formulario__input-error">Debe seleccionar un asentamiento.</p>
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--calle">
                <label class="form-label" for="calle">Calle</label>
                <input type="text" id="calle" name="calle" class="form-control" placeholder="Ej: Av. Principal">
                <p class="formulario__input-error">La calle debe contener letras, números o espacios, máximo 100 caracteres.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--numero_exterior">
                <label class="form-label" for="numero_exterior">Número Exterior</label>
                <input type="text" id="numero_exterior" name="numero_exterior" class="form-control" placeholder="Ej: 123">
                <p class="formulario__input-error">El número exterior debe contener letras o números, máximo 10 caracteres.</p>
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--numero_interior">
                <label class="form-label" for="numero_interior">Número Interior</label>
                <input type="text" id="numero_interior" name="numero_interior" class="form-control" placeholder="Ej: 5A">
                <p class="formulario__input-error">El número interior debe contener letras o números, máximo 10 caracteres, o dejar en blanco.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--entre_calle_1">
                <label class="form-label" for="entre_calle_1">Entre Calle 1</label>
                <input type="text" id="entre_calle_1" name="entre_calle_1" class="form-control" placeholder="Ej: Calle Independencia">
                <p class="formulario__input-error">Entre calle 1 debe contener letras, números o espacios, máximo 100 caracteres, o dejar en blanco.</p>
            </div>
        </div>
        <div class="form-group" id="formulario__grupo--entre_calle_2">
            <label class="form-label" for="entre_calle_2">Entre Calle 2</label>
            <input type="text" id="entre_calle_2" name="entre_calle_2" class="form-control" placeholder="Ej: Calle Morelos">
            <p class="formulario__input-error">Entre calle 2 debe contener letras, números o espacios, máximo 100 caracteres, o dejar en blanco.</p>
        </div>
    </div>
</form>