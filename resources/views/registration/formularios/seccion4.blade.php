<div class="form-section" id="form-step-4">
  <div class="form-container">
      <div class="form-column">
          <div class="form-header">
              <h4><i class="fas fa-users"></i> Socios o Accionistas (Persona Moral)</h4>
              <p class="subtitle">Agrega los socios o accionistas de la empresa</p>
              <div class="percentage-summary">
                  <div class="progress-bar-container">
                      <div class="progress-bar" id="percentage-bar"></div>
                  </div>
                  <span id="percentage-text">0% asignado</span>
              </div>
          </div>
          
          <div class="shareholders-container" id="shareholders-container">
              <!-- Las tarjetas de accionistas se agregarán aquí dinámicamente -->
          </div>
          
          <button type="button" id="add-shareholder" class="btn-add-shareholder">
              <i class="fas fa-plus-circle"></i> Agregar Socio/Accionista
          </button>
      </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('shareholders-container');
    const addBtn = document.getElementById('add-shareholder');
    const percentageBar = document.getElementById('percentage-bar');
    const percentageText = document.getElementById('percentage-text');
    
    let shareholderCount = 0;
    
    // Función para agregar un nuevo accionista
    function addShareholder() {
        shareholderCount++;
        const card = document.createElement('div');
        card.className = 'shareholder-card';
        card.innerHTML = `
            <div class="shareholder-header">
                <div class="shareholder-number">${shareholderCount}</div>
                <button type="button" class="btn-delete-shareholder" title="Eliminar accionista">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="form-group-shareholder">
                <label for="lastname1-${shareholderCount}">Apellido Paterno</label>
                <input type="text" id="lastname1-${shareholderCount}" class="form-control-shareholder" placeholder="Ej: González">
            </div>
            <div class="form-group-shareholder">
                <label for="lastname2-${shareholderCount}">Apellido Materno</label>
                <input type="text" id="lastname2-${shareholderCount}" class="form-control-shareholder" placeholder="Ej: López">
            </div>
            <div class="form-group-shareholder">
                <label for="name-${shareholderCount}">Nombre(s)</label>
                <input type="text" id="name-${shareholderCount}" class="form-control-shareholder" placeholder="Ej: Juan Carlos">
            </div>
            <div class="form-group-shareholder">
                <label for="percentage-${shareholderCount}">Porcentaje de Acciones</label>
                <div class="percentage-input-container">
                    <input type="number" id="percentage-${shareholderCount}" 
                           class="form-control-shareholder percentage-input" 
                           placeholder="Ej: 50" min="0" max="100">
                    <span class="percentage-suffix">%</span>
                </div>
            </div>
        `;
        
        container.appendChild(card);
        
        // Enfocar el primer campo del nuevo accionista
        const firstInput = card.querySelector('input');
        if (firstInput) firstInput.focus();
        
        updatePercentageSummary();
    }
    
    // Función para eliminar un accionista
    function deleteShareholder(card) {
        if (container.children.length > 1) {
            card.remove();
            updateShareholderNumbers();
            updatePercentageSummary();
        } else {
            alert('Debe haber al menos un socio/accionista registrado.');
        }
    }
    
    // Función para actualizar los números de los accionistas
    function updateShareholderNumbers() {
        const cards = container.querySelectorAll('.shareholder-card');
        cards.forEach((card, index) => {
            card.querySelector('.shareholder-number').textContent = index + 1;
        });
        shareholderCount = cards.length;
    }
    
    // Función para calcular y mostrar el resumen de porcentajes
    function updatePercentageSummary() {
        const inputs = container.querySelectorAll('.percentage-input');
        let total = 0;
        
        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        
        // Actualizar barra y texto
        const percentage = Math.min(total, 100);
        percentageBar.style.width = `${percentage}%`;
        
        if (total > 100) {
            percentageText.textContent = `⚠️ ${total}% (Excede el 100%)`;
            percentageText.style.color = '#dc3545';
            percentageBar.style.background = '#dc3545';
        } else {
            percentageText.textContent = `${percentage}% asignado`;
            percentageText.style.color = percentage === 100 ? '#28a745' : '#4e73df';
            percentageBar.style.background = percentage === 100 ? '#28a745' : '#4e73df';
        }
    }
    
    // Event listeners
    addBtn.addEventListener('click', addShareholder);
    
    container.addEventListener('click', (e) => {
        if (e.target.closest('.btn-delete-shareholder')) {
            const card = e.target.closest('.shareholder-card');
            deleteShareholder(card);
        }
    });
    
    container.addEventListener('input', (e) => {
        if (e.target.classList.contains('percentage-input')) {
            // Validar que no se ingresen valores mayores a 100
            if (parseInt(e.target.value) > 100) {
                e.target.value = 100;
            }
            updatePercentageSummary();
        }
    });
    
    // Agregar primer accionista por defecto
    addShareholder();
});
  </Script>