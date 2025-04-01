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

function showSATDataModal(satData) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay sat-modal';
    modal.innerHTML = `
        <div class="modal-container">
            <div class="modal-header">
                <h3>Información del SAT</h3>
                <button class="icon-btn close-modal">×</button>
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

const satModalStyles = document.createElement('style');
satModalStyles.textContent = `
    .sat-modal .modal-container {
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
    }
    
    .sat-modal .modal-body {
        overflow-y: auto;
        max-height: calc(80vh - 120px);
        padding: 16px;
    }
    
    .sat-section {
        margin-bottom: 24px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .sat-section h4 {
        margin: 0;
        padding: 12px 16px;
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
        font-size: 0.9rem;
        color: #111827;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .sat-section table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
    }
    
    .sat-section th, 
    .sat-section td {
        padding: 8px 12px;
        text-align: left;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .sat-section th {
        background: #F3F4F6;
        font-weight: 500;
        color: #374151;
        width: 40%;
    }
    
    .sat-section tr:last-child th,
    .sat-section tr:last-child td {
        border-bottom: none;
    }
    
    .sat-section tr:hover td {
        background: #F9FAFB;
    }
    
    .modal-footer {
        display: flex;
        justify-content: space-between;
    }
    
    .small-btn.primary {
        background-color: #1D4ED8;
        color: white;
        border: 1px solid #1D4ED8;
    }
    
    .small-btn.primary:hover {
        background-color: #1E40AF;
        border-color: #1E40AF;
    }
`;
document.head.appendChild(satModalStyles);

window.scrapeSATData = scrapeSATData;
window.showSATDataModal = showSATDataModal;