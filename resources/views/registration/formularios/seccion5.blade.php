<form id="formulario5">
    <div id="section-5" class="form-section">
        <div class="form-container">
            <!-- Primera columna -->
            <div class="form-column">
                <div class="form-group">
                    <h4><i class="fas fa-user-tie"></i> Datos del Apoderado o Representante Legal</h4>
                </div>
                <div class="form-group horizontal-group">
                    <!-- Nombre del apoderado -->
                    <div class="half-width formulario__grupo" id="grupo__nombre-apoderado">
                        <label class="form-label" for="nombre-apoderado">Nombre</label>
                        <input type="text" id="nombre-apoderado" name="nombre-apoderado" class="form-control" placeholder="Nombre completo del apoderado o representante legal">
                        <p class="formulario__input-error">El nombre solo puede contener letras y espacios, máximo 100 caracteres.</p>
                    </div>
                    <!-- Número de Escritura -->
                    <div class="half-width formulario__grupo" id="grupo__numero-escritura">
                        <label class="form-label" for="numero-escritura">Número de Escritura</label>
                        <input type="text" id="numero-escritura" name="numero-escritura" class="form-control" placeholder="Número de escritura">
                        <p class="formulario__input-error">El número de escritura debe contener solo números, máximo 10 dígitos.</p>
                    </div>
                </div>
                <div class="form-group horizontal-group">
                    <!-- Nombre del Notario -->
                    <div class="half-width formulario__grupo" id="grupo__nombre-notario">
                        <label class="form-label" for="nombre-notario">Nombre del Notario</label>
                        <input type="text" id="nombre-notario" name="nombre-notario" class="form-control" placeholder="Nombre del notario">
                        <p class="formulario__input-error">El nombre del notario solo puede contener letras y espacios, máximo 100 caracteres.</p>
                    </div>
                    <!-- Número del Notario -->
                    <div class="half-width formulario__grupo" id="grupo__numero-notario">
                        <label class="form-label" for="numero-notario">Número del Notario</label>
                        <input type="text" id="numero-notario" name="numero-notario" class="form-control" placeholder="Número del notario">
                        <p class="formulario__input-error">El número del notario debe contener solo números, máximo 10 dígitos.</p>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label" for="entidad_federativa_5">Entidad Federativa</label>
                        <select id="entidad_federativa_5" name="entidad_federativa" class="form-control">
                            <option value="">Seleccione un estado</option>
                        </select>
                        <p class="formulario__input-error">Por favor, seleccione una entidad federativa.</p>
                    </div>
                    <!-- Fecha de Escritura -->
                    <div class="half-width formulario__grupo" id="grupo__fecha-escritura">
                        <label class="form-label" for="fecha-escritura">Fecha</label>
                        <input type="date" id="fecha-escritura" name="fecha-escritura" class="form-control">
                        <p class="formulario__input-error">Por favor seleccione una fecha válida.</p>
                    </div>
                </div>
            </div>
            <!-- Segunda columna -->
            <div class="form-column">
                <div class="form-group">
                    <h4><i class="fas fa-book"></i> Datos de Inscripción en el Registro Público</h4>
                </div>
                <div class="form-group formulario__grupo" id="grupo__numero-registro">
                    <label class="form-label" for="numero-registro">Número de Registro o Folio Mercantil</label>
                    <input type="text" id="numero-registro" name="numero-registro" class="form-control" placeholder="Número de registro o folio mercantil">
                    <p class="formulario__input-error">El número de registro debe contener solo números, máximo 10 dígitos.</p>
                </div>
                <div class="form-group formulario__grupo" id="grupo__fecha-inscripcion">
                    <label class="form-label" for="fecha-inscripcion">Fecha de Inscripción</label>
                    <input type="date" id="fecha-inscripcion" name="fecha-inscripcion" class="form-control">
                    <p class="formulario__input-error">Por favor seleccione una fecha válida.</p>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cargar estados al cargar la página
    cargarEstados();

    function cargarEstados() {
        const select = document.getElementById('entidad_federativa_5');
        if (!select) {
            console.error('No se encontró el elemento con ID entidad_federativa_5');
            return;
        }
        if (select.options.length > 1) {
            console.log('Los estados ya están cargados');
            return; // Ya están cargados
        }

        fetch('/estados')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Limpiar opciones excepto la primera
                while (select.options.length > 1) {
                    select.remove(1);
                }

                // Agregar estados
                data.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.id;
                    option.textContent = estado.nombre;
                    select.appendChild(option);
                });
                console.log('Estados cargados exitosamente');
            })
            .catch(error => console.error('Error al cargar estados:', error));
    }
});
</script>