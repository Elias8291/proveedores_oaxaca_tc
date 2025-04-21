<form id="formulario2">
    <div class="form-section" id="form-step-2">
        <h4><i class="fas fa-map-marker-alt"></i> Domicilio</h4>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--codigo_postal">
                <label class="form-label data-label">Código Postal</label>
                @if (Auth::user()->hasRole('solicitante'))
                    <span class="data-field" id="codigo_postal_display">{{ Auth::user()->solicitante->codigo_postal ?? 'No disponible' }}</span>
                    <input type="hidden" id="codigo_postal" name="codigo_postal" value="{{ Auth::user()->solicitante->codigo_postal ?? '' }}">
                @else
                    <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" placeholder="Ej: 12345" required pattern="[0-9]{5}" maxlength="5" value="{{ Auth::user()->solicitante->codigo_postal ?? '' }}">
                    <p class="formulario__input-error">El código postal debe contener exactamente 5 dígitos numéricos.</p>
                @endif
            </div>
            <div class="half-width form-group" id="formulario__grupo--estado">
                <label class="form-label data-label">Estado</label>
                @if (Auth::user()->hasRole('solicitante'))
                    <span class="data-field" id="estado_display">{{ Auth::user()->solicitante->estado ?? 'No disponible' }}</span>
                    <input type="hidden" id="estado" name="estado" value="{{ Auth::user()->solicitante->estado ?? '' }}">
                @else
                    <input type="text" id="estado" name="estado" class="form-control" placeholder="Ej: Jalisco" required maxlength="100" pattern="[A-Za-z\s]+" value="{{ Auth::user()->solicitante->estado ?? '' }}">
                    <p class="formulario__input-error">El estado debe contener solo letras y espacios, máximo 100 caracteres.</p>
                @endif
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--municipio">
                <label class="form-label data-label">Municipio</label>
                @if (Auth::user()->hasRole('solicitante'))
                    <span class="data-field" id="municipio_display">{{ Auth::user()->solicitante->municipio ?? 'No disponible' }}</span>
                    <input type="hidden" id="municipio" name="municipio" value="{{ Auth::user()->solicitante->municipio ?? '' }}">
                @else
                    <input type="text" id="municipio" name="municipio" class="form-control" placeholder="Ej: Guadalajara" required maxlength="100" pattern="[A-Za-z\s]+" value="{{ Auth::user()->solicitante->municipio ?? '' }}">
                    <p class="formulario__input-error">El municipio debe contener solo letras y espacios, máximo 100 caracteres.</p>
                @endif
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
                <input type="text" id="calle" name="calle" class="form-control" placeholder="Ej: Av. Principal" required maxlength="100" pattern="[A-Za-z0-9\s]+" value="{{ Auth::user()->solicitante->calle ?? '' }}">
                <p class="formulario__input-error">La calle debe contener letras, números o espacios, máximo 100 caracteres.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--numero_exterior">
                <label class="form-label" for="numero_exterior">Número Exterior</label>
                <input type="text" id="numero_exterior" name="numero_exterior" class="form-control" placeholder="Ej: 123" required maxlength="10" pattern="[A-Za-z0-9]+" value="{{ Auth::user()->solicitante->numero_exterior ?? '' }}">
                <p class="formulario__input-error">El número exterior debe contener letras o números, máximo 10 caracteres.</p>
            </div>
        </div>
        <div class="form-group horizontal-group">
            <div class="half-width form-group" id="formulario__grupo--numero_interior">
                <label class="form-label" for="numero_interior">Número Interior</label>
                <input type="text" id="numero_interior" name="numero_interior" class="form-control" placeholder="Ej: 5A" maxlength="10" pattern="[A-Za-z0-9]+" value="{{ Auth::user()->solicitante->numero_interior ?? '' }}">
                <p class="formulario__input-error">El número interior debe contener letras o números, máximo 10 caracteres, o dejar en blanco.</p>
            </div>
            <div class="half-width form-group" id="formulario__grupo--entre_calle_1">
                <label class="form-label" for="entre_calle_1">Entre Calle 1</label>
                <input type="text" id="entre_calle_1" name="entre_calle_1" class="form-control" placeholder="Ej: Calle Independencia" maxlength="100" pattern="[A-Za-z0-9\s]+" value="{{ Auth::user()->solicitante->entre_calle_1 ?? '' }}">
                <p class="formulario__input-error">Entre calle 1 debe contener letras, números o espacios, máximo 100 caracteres, o dejar en blanco.</p>
            </div>
        </div>
        <div class="form-group" id="formulario__grupo--entre_calle_2">
            <label class="form-label" for="entre_calle_2">Entre Calle 2</label>
            <input type="text" id="entre_calle_2" name="entre_calle_2" class="form-control" placeholder="Ej: Calle Morelos" maxlength="100" pattern="[A-Za-z0-9\s]+" value="{{ Auth::user()->solicitante->entre_calle_2 ?? '' }}">
            <p class="formulario__input-error">Entre calle 2 debe contener letras, números o espacios, máximo 100 caracteres, o dejar en blanco.</p>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const isSolicitante = @json(Auth::user()->hasRole('solicitante'));
    
        if (isSolicitante) {
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
                        if (data.colonia && asentamiento.id == data.colonia) {
                            option.selected = true;
                        }
                        coloniaSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error al cargar datos de dirección:', error);
                // Reset fields on error
                document.getElementById('codigo_postal_display').textContent = 'No disponible';
                document.getElementById('codigo_postal').value = '';
                document.getElementById('estado_display').textContent = 'No disponible';
                document.getElementById('estado').value = '';
                document.getElementById('municipio_display').textContent = 'No disponible';
                document.getElementById('municipio').value = '';
                document.getElementById('colonia').innerHTML = '<option value="">Seleccione un Asentamiento</option>';
            });
        } else {
            // For revisor_1, initialize colonia dropdown as empty
            const coloniaSelect = document.getElementById('colonia');
            coloniaSelect.innerHTML = '<option value="">Seleccione un Asentamiento</option>';
        }
    });
    </script>