<form id="formulario2">
    <div class="form-section" id="form-step-2">
        <h4><i class="fas fa-map-marker-alt"></i> Domicilio</h4>
        <div class="form-group horizontal-group">
            <div class="half-width">
                <label class="form-label data-label">Código Postal</label>
                <span class="data-field" id="codigo_postal_display">No disponible</span>
                <input type="hidden" id="codigo_postal" name="codigo_postal" value="">
            </div>
            <div class="half-width">
                <label class="form-label data-label">Estado</label>
                <span class="data-field" id="estado_display">No disponible</span>
                <input type="hidden" id="estado" name="estado" value="">
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width">
                <label class="form-label data-label">Municipio</label>
                <span class="data-field" id="municipio_display">No disponible</span>
                <input type="hidden" id="municipio" name="municipio" value="">
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
                <input type="text" id="calle" name="calle" class="form-control"
                    placeholder="Ej: Av. Principal">
                <p class="formulario__input-error">La calle debe contener letras, números o espacios, máximo 100
                    caracteres.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--numero_exterior">
                <label class="form-label" for="numero_exterior">Número Exterior</label>
                <input type="text" id="numero_exterior" name="numero_exterior" class="form-control"
                    placeholder="Ej: 123">
                <p class="formulario__input-error">El número exterior debe contener letras o números, máximo 10
                    caracteres.</p>
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--numero_interior">
                <label class="form-label" for="numero_interior">Número Interior</label>
                <input type="text" id="numero_interior" name="numero_interior" class="form-control"
                    placeholder="Ej: 5A">
                <p class="formulario__input-error">El número interior debe contener letras o números, máximo 10
                    caracteres, o dejar en blanco.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--entre_calle_1">
                <label class="form-label" for="entre_calle_1">Entre Calle 1</label>
                <input type="text" id="entre_calle_1" name="entre_calle_1" class="form-control"
                    placeholder="Ej: Calle Independencia">
                <p class="formulario__input-error">Entre calle 1 debe contener letras, números o espacios, máximo 100
                    caracteres, o dejar en blanco.</p>
            </div>
        </div>
        <div class="form-group" id="formulario__grupo--entre_calle_2">
            <label class="form-label" for="entre_calle_2">Entre Calle 2</label>
            <input type="text" id="entre_calle_2" name="entre_calle_2" class="form-control"
                placeholder="Ej: Calle Morelos">
            <p class="formulario__input-error">Entre calle 2 debe contener letras, números o espacios, máximo 100
                caracteres, o dejar en blanco.</p>
        </div>
    </div>
</form>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    fetch('/solicitante/direccion-data', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            console.error('Error from server:', data.error);
            alert('No se pudieron cargar los datos de dirección. Por favor, intenta de nuevo.');
            return;
        }

        // Populate postal code
        document.getElementById('codigo_postal_display').textContent = data.codigo_postal || 'No disponible';
        document.getElementById('codigo_postal').value = data.codigo_postal || '';

        // Populate estado
        document.getElementById('estado_display').textContent = data.estado || 'No disponible';
        document.getElementById('estado').value = data.estado || '';

        // Populate municipio
        document.getElementById('municipio_display').textContent = data.municipio || 'No disponible';
        document.getElementById('municipio').value = data.municipio || '';

        // Populate asentamientos dropdown
        const coloniaSelect = document.getElementById('colonia');
        coloniaSelect.innerHTML = '<option value="">Seleccione un Asentamiento</option>';
        if (data.asentamientos && data.asentamientos.length > 0) {
            data.asentamientos.forEach(asentamiento => {
                const option = document.createElement('option');
                option.value = asentamiento.id; // Use ID for submission
                option.textContent = asentamiento.nombre;
                coloniaSelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error al cargar datos de dirección:', error);
        alert('Ocurrió un error al cargar los datos de dirección. Por favor, intenta de nuevo.');
        // Reset fields on error
        document.getElementById('codigo_postal_display').textContent = 'No disponible';
        document.getElementById('codigo_postal').value = '';
        document.getElementById('estado_display').textContent = 'No disponible';
        document.getElementById('estado').value = '';
        document.getElementById('municipio_display').textContent = 'No disponible';
        document.getElementById('municipio').value = '';
        document.getElementById('colonia').innerHTML = '<option value="">Seleccione un Asentamiento</option>';
    });
});
</script>
