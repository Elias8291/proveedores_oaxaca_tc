import { createModal } from './utils.js';

export async function scrapeSATData(qrUrl) {
    try {
        const response = await fetch(qrUrl, {
            headers: {
                'Accept': 'text/html',
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0.4472.124 Safari/537.36'
            }
        });
        if (!response.ok) throw new Error(`Error: ${response.status} ${response.statusText}`);
        const doc = new DOMParser().parseFromString(await response.text(), 'text/html');
        const extractedData = [];
        let email = '';
        let razonSocial = '';
        let nombre = '';
        let apellidoPaterno = '';
        let apellidoMaterno = '';

        doc.querySelectorAll('[data-role="listview"]').forEach((section, index) => {
            const titleElement = section.querySelector('[data-role="list-divider"]');
            const sectionTitle = titleElement ? titleElement.textContent.trim() : `Sección ${index + 1}`;
            if (sectionTitle === "" || !section.querySelector('table')) return;

            const sectionData = { sectionNumber: index + 1, sectionName: sectionTitle, fields: [] };
            section.querySelectorAll('tr[data-ri]').forEach(row => {
                const cells = row.querySelectorAll('td[role="gridcell"]');
                if (cells.length >= 2) {
                    const label = cells[0].textContent.replace(/:/g, '').trim();
                    const value = cells[1].textContent.trim();
                    if (label && value && !value.includes('$(function') && !sectionData.fields.some(f => f.label === label)) {
                        if ((label.toLowerCase().includes('correo') || label.toLowerCase().includes('email'))) {
                            email = value;
                        }
                        if (label.toLowerCase().includes('denominación') || label.toLowerCase().includes('razón social')) {
                            razonSocial = value;
                        }
                        if (label.toLowerCase() === 'nombre'){
                            nombre = value;
                        }
                        if (label.toLowerCase().includes('apellido paterno')) {
                            apellidoPaterno = value;
                        }
                        if (label.toLowerCase().includes('apellido materno')) {
                            apellidoMaterno = value;
                        }
                        sectionData.fields.push({ label, value });
                    }
                }
            });
            if (sectionData.fields.length > 0) extractedData.push(sectionData);
        });
        const nombreCompleto = [nombre, apellidoPaterno, apellidoMaterno]
            .filter(part => part && part.trim() !== '')
            .join(' ');

        return { extractedData, email, razonSocial, nombreCompleto };
    } catch (error) {
        throw new Error(`No se pudo obtener la información del SAT: ${error.message}`);
    }
}

export function showSATDataModal(satData, qrUrl) {
    createModal({
        className: 'modal-overlay sat-modal',
        html: `
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
                    ${satData.extractedData.length === 0 ? '<p>No se encontraron datos en la página del SAT.</p>' : 
                        satData.extractedData.map(s => `
                            <div class="sat-section">
                                <h4>${s.sectionName}</h4>
                                <div class="table-responsive">
                                    <table>
                                        <tbody>
                                            ${s.fields.map(f => `<tr><th>${f.label}</th><td>${f.value}</td></tr>`).join('')}
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
        `
    });
}

const style = document.createElement('style');
style.textContent = `
    .email-display {
        padding: 10px;
        margin: 10px 0;
        background-color: #f5f5f5;
        border-radius: 4px;
    }
    .name-display {
        padding: 10px;
        margin: 10px 0;
        background-color: #f5f5f5;
        border-radius: 4px;
    }
`;
document.head.appendChild(style);