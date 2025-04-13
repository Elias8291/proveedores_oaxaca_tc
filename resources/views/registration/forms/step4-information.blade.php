<div class="form-section" id="form-step-4">
    <div class="form-container">
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-users"></i> Socios o Accionistas (Persona Moral)</h4>
            </div>
            <div class="form-group">
                <div class="table-container">
                    <table class="socios-table" id="tabla-socios">
                        <thead>
                            <tr>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombre(s)</th>
                                <th>Porcentaje de Acciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Fila de ejemplo -->
                            <tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Apellido Paterno">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Apellido Materno">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Nombre(s)">
                                </td>
                                <td>
                                    <div class="input-with-suffix">
                                        <input type="text" class="form-control porcentaje-input" placeholder="Ej: 50">
                                        <span class="input-suffix">%</span>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn-delete eliminar-socio">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" id="agregar-socio" class="btn-add mt-2">
                    <i class="fas fa-plus"></i> Agregar Socio
                </button>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
    const tablaSocios = document.getElementById('tabla-socios');
    const agregarSocioBtn = document.getElementById('agregar-socio');
  
    // Function to add a new socio row
    function agregarSocio() {
      const tbody = tablaSocios.querySelector('tbody');
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>
          <input type="text" class="form-control" placeholder="Apellido Paterno">
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Apellido Materno">
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Nombre(s)">
        </td>
        <td>
          <div class="input-with-suffix">
            <input type="text" class="form-control porcentaje-input" placeholder="Ej: 50">
            <span class="input-suffix">%</span>
          </div>
        </td>
        <td>
          <button type="button" class="btn-delete eliminar-socio">
            <i class="fas fa-trash"></i> Eliminar
          </button>
        </td>
      `;
      tbody.appendChild(newRow);
    }
  
    // Event listener for adding a socio
    agregarSocioBtn.addEventListener('click', agregarSocio);
  
    // Event listener for deleting a socio
    tablaSocios.addEventListener('click', (e) => {
      if (e.target.closest('.eliminar-socio')) {
        const row = e.target.closest('tr');
        const tbody = tablaSocios.querySelector('tbody');
        if (tbody.children.length > 1) {
          row.remove();
        } else {
          alert('Debe haber al menos un socio registrado.');
        }
      }
    });
  
    // Optional: Validate percentage inputs
    tablaSocios.addEventListener('input', (e) => {
      if (e.target.classList.contains('porcentaje-input')) {
        const value = e.target.value;
        if (value && !/^\d*$/.test(value)) {
          e.target.value = value.replace(/[^0-9]/g, '');
        }
      }
    });
  
    // Optional: Check total percentage (uncomment to enable)
    /*
    function checkTotalPercentage() {
      const inputs = tablaSocios.querySelectorAll('.porcentaje-input');
      let total = 0;
      inputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
      });
      if (total > 100) {
        alert('El total de porcentajes no puede exceder el 100%.');
      }
    }
  
    tablaSocios.addEventListener('change', (e) => {
      if (e.target.classList.contains('porcentaje-input')) {
        checkTotalPercentage();
      }
    });
    */
  });

  </Script>