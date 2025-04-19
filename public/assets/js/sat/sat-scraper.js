import { createModal } from './utils.js';

// Scrape SAT data from the provided QR URL
export async function scrapeSATData(qrUrl) {
    try {
        const response = await fetch(qrUrl, {
            headers: {
                Accept: 'text/html',
                'User-Agent':
                    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0.4472.124 Safari/537.36',
            },
        });
        if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);

        const html = await response.text();
        const doc = new DOMParser().parseFromString(html, 'text/html');

        // Initialize data variables
        const data = {
            extractedData: [],
            email: '',
            razonSocial: '',
            nombre: '',
            apellidoPaterno: '',
            apellidoMaterno: '',
            rfc: '',
            cp: '',
            colonia: '',
            nombreVialidad: '',
            numeroExterior: '',
            numeroInterior: '',
            tipoPersona: '',
        };

        // Extract RFC
        const rfcMatch = html.match(/RFC:\s*([A-Z0-9]+)/i);
        if (rfcMatch) data.rfc = rfcMatch[1];

        // Extract fields from listview sections
        doc.querySelectorAll('[data-role="listview"]').forEach((section, index) => {
            const title =
                section.querySelector('[data-role="list-divider"]')?.textContent.trim() ||
                `Section ${index + 1}`;
            if (!section.querySelector('table')) return;

            const sectionData = { sectionNumber: index + 1, sectionName: title, fields: [] };
            section.querySelectorAll('tr[data-ri]').forEach((row) => {
                const [labelCell, valueCell] = row.querySelectorAll('td[role="gridcell"]');
                if (!labelCell || !valueCell) return;

                const label = labelCell.textContent.replace(/:/g, '').trim();
                const value = valueCell.textContent.trim();
                if (!label || !value || value.includes('$(function') || sectionData.fields.some((f) => f.label === label)) return;

                // Assign values to data object
                if (/correo|email/i.test(label)) data.email = value;
                if (/denominación|razón social/i.test(label)) data.razonSocial = value;
                if (label.toLowerCase() === 'nombre') data.nombre = value;
                if (/apellido paterno/i.test(label)) data.apellidoPaterno = value;
                if (/apellido materno/i.test(label)) data.apellidoMaterno = value;
                if (/rfc/i.test(label)) data.rfc = value;
                if (/código postal|cp/i.test(label)) data.cp = value;
                if (/colonia/i.test(label)) data.colonia = value;
                if (/nombre de la vialidad|calle|vialidad/i.test(label)) data.nombreVialidad = value;
                if (/número exterior|numero exterior|no exterior/i.test(label)) data.numeroExterior = value;
                if (/número interior|numero interior|no interior/i.test(label)) data.numeroInterior = value;

                sectionData.fields.push({ label, value });
            });

            if (sectionData.fields.length) data.extractedData.push(sectionData);
        });

        // Construct nombreCompleto
        data.nombreCompleto = [data.nombre, data.apellidoPaterno, data.apellidoMaterno]
            .filter(Boolean)
            .join(' ');

        // Determine tipoPersona and finalNombre
        data.finalNombre = '';
        if (data.rfc.length === 12) {
            data.tipoPersona = 'Moral';
            data.finalNombre = data.razonSocial;
        } else if (data.rfc.length === 13) {
            data.tipoPersona = 'Física';
            data.finalNombre = data.nombreCompleto;
            data.razonSocial = data.nombreCompleto;
        } else {
            data.tipoPersona = 'Desconocido';
        }

        return data;
    } catch (error) {
        throw new Error(`Failed to fetch SAT data: ${error.message}`);
    }
}

// Display SAT data in a modal
export function showSATDataModal(satData, qrUrl) {
    const modalHtml = `
        <div class="modal-container">
            <div class="modal-header">
                <h3>Información del SAT</h3>
                <div class="header-actions">
                    <button class="icon-btn link-btn" onclick="window.open('${qrUrl}', '_blank')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                    </button>
                    <button class="icon-btn close-modal">×</button>
                </div>
            </div>
            <div class="modal-body">
                ${satData.email ? `<div class="email-display"><strong>Correo:</strong> ${satData.email}</div>` : ''}
                ${
                    satData.extractedData.length === 0
                        ? '<p>No se encontraron datos en la página del SAT.</p>'
                        : satData.extractedData
                              .map(
                                  (s, index) => `
                                    <div class="sat-section">
                                        <h4>${s.sectionName}</h4>
                                        <div class="table-responsive">
                                            <table>
                                                <tbody>
                                                    ${index === 0 && satData.rfc ? `<tr><th>RFC</th><td>${satData.rfc}</td></tr>` : ''}
                                                    ${s.fields.map((f) => `<tr><th>${f.label}</th><td>${f.value}</td></tr>`).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  `
                              )
                              .join('')
                }
            </div>
            <div class="modal-footer">
                <button class="small-btn outline" id="closeModalBtn">Cerrar</button>
            </div>
        </div>
    `;
    createModal({ className: 'modal-overlay sat-modal', html: modalHtml });
}