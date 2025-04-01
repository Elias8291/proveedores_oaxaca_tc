async function scrapeSATData(qrUrl) {
    try {
        const response = await fetch(qrUrl, {
            headers: {
                'Accept': 'text/html',
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            }
        });
        
        if (!response.ok) {
            throw new Error(`Error al acceder a la página: ${response.status} ${response.statusText}`);
        }
        
        const html = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Find the sections with data
        const sections = doc.querySelectorAll('[data-role="listview"]');
        const extractedData = [];
        
        sections.forEach((section, index) => {
            // Get the title from the list-divider element
            const titleElement = section.querySelector('[data-role="list-divider"]');
            let sectionTitle = titleElement ? titleElement.textContent.trim() : `Sección ${index + 1}`;
            
            // Skip empty sections
            if (sectionTitle === "" || !section.querySelector('table')) {
                return;
            }
            
            // Create a section data object
            const sectionData = {
                sectionNumber: index + 1,
                sectionName: sectionTitle,
                fields: []
            };
            
            // Find all rows with actual data (avoiding JS function calls)
            const rows = section.querySelectorAll('tr[data-ri]');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td[role="gridcell"]');
                if (cells.length >= 2) {
                    // First cell contains label, second contains value
                    const label = cells[0].textContent.replace(/:/g, '').trim();
                    const value = cells[1].textContent.trim();
                    
                    // Skip duplicate entries and script calls
                    if (label && value && !value.includes('$(function') && !sectionData.fields.some(field => field.label === label)) {
                        sectionData.fields.push({
                            label: label,
                            value: value
                        });
                    }
                }
            });
            
            // Only add sections with actual data
            if (sectionData.fields.length > 0) {
                extractedData.push(sectionData);
            }
        });
        
        return extractedData;
        
    } catch (error) {
        console.error('Error en el scraping:', error);
        throw new Error(`No se pudo obtener la información del SAT: ${error.message}`);
    }
}
function showSATDataModal(satData, qrUrl) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay sat-modal';
    modal.innerHTML = `
        <div class="modal-container">
            <div class="modal-header">
                <h3>Información del SAT</h3>
                <div class="header-actions">
                    <button class="icon-btn link-btn" title="Ver página de origen" onclick="window.open('${qrUrl}', '_blank')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                    </button>
                    <button class="icon-btn close-modal">×</button>
                </div>
            </div>
            <div class="modal-body">
                ${satData.length === 0 ? 
                    '<p>No se encontraron datos en la página del SAT.</p>' : 
                    satData.map(section => `
                        <div class="sat-section">
                            <h4>${section.sectionName}</h4>
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        ${section.fields.map(field => `
                                            <tr>
                                                <th>${field.label}</th>
                                                <td>${field.value}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `).join('')
                }
            </div>
            <div class="modal-footer">
                <button class="small-btn outline" id="closeModalBtn">Cerrar</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Funciones para cerrar el modal
    const closeModal = () => document.body.removeChild(modal);
    modal.querySelector('.close-modal').addEventListener('click', closeModal);
    modal.querySelector('#closeModalBtn').addEventListener('click', closeModal);
    modal.addEventListener('click', e => e.target === modal && closeModal());
}


window.scrapeSATData = scrapeSATData;
window.showSATDataModal = showSATDataModal;