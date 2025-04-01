// templates.js
export const errorCardTemplate = `
    <div class="error-card">
        <div class="error-header">
            <svg class="error-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="error-text">
                <h3>Documento inválido</h3>
                <p>{{message}}</p>
            </div>
        </div>
        <div class="error-actions">
            <button class="small-btn outline" id="viewDetailsBtn"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 14.6667C11.6819 14.6667 14.6667 11.6819 14.6667 8C14.6667 4.3181 11.6819 1.33333 8 1.33333C4.3181 1.33333 1.33333 4.3181 1.33333 8C1.33333 11.6819 4.3181 14.6667 8 14.6667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 10.6667V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 5.33333H8.00667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Detalles</button>
            <button class="small-btn" id="tryAgainBtn"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.3333 2.66699C12.0697 3.22866 12.6213 3.98033 12.9253 4.83199M14 7.33366C13.9975 6.455 13.7318 5.598 13.236 4.87366M12.9333 9.83366C12.624 10.6823 12.076 11.4303 11.344 11.9877M9.33333 13.3337C8.597 13.8943 7.69767 14.1963 6.77067 14.1963C5.84367 14.1963 4.94433 13.8943 4.208 13.3337M2.66667 11.3337C2.106 10.5973 1.804 9.698 1.804 8.771C1.804 7.844 2.106 6.94466 2.66667 6.20833M2.06667 6.16699C2.376 5.31833 2.924 4.57033 3.656 4.01299M4.66667 2.66699C5.403 2.10633 6.30233 1.80433 7.22933 1.80433C8.15633 1.80433 9.05567 2.10633 9.792 2.66699" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Subir otro</button>
        </div>
    </div>
`;

export const errorDetailsModalTemplate = `
    <div class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Detalles del error</h3>
                <button class="icon-btn close-modal">×</button>
            </div>
            <div class="modal-body">
                <p>{{message}}</p>
                <div class="tip-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 8V12" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16H12.01" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <p>Asegúrate de subir una constancia de situación fiscal válida con código QR legible.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="small-btn" id="viewExampleBtn"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 10V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 2H14V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.3335 6.66667L14.0002 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Ver ejemplo</button>
                <button class="small-btn outline" id="closeModalBtn">Entendido</button>
            </div>
        </div>
    </div>
`;

export const pdfModalTemplate = `
    <div class="pdf-modal-overlay">
        <div class="pdf-modal-container">
            <div class="pdf-modal-header">
                <h3>Ejemplo de Constancia</h3>
                <button class="icon-btn close-pdf-modal">×</button>
            </div>
            <div class="pdf-modal-body">
                <div id="pdf-viewer-container"></div>
                <div class="pdf-loader"><div class="pdf-spinner"></div><p>Cargando documento...</p></div>
            </div>
            <div class="pdf-modal-footer">
                <button class="small-btn outline" id="closePdfModalBtn">Cerrar</button>
            </div>
        </div>
    </div>
`;

export const successCardTemplate = `
    <div class="success-card {{statusClass}}">
        <div class="success-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.7088 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 4L12 14.01L9 11.01" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3>Documento {{estatusText}}</h3>
            {{warningBadge}}
            <button class="icon-btn" id="viewPdfBtn" title="Ver PDF"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 10V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 2H14V6" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.3335 6.66667L14.0002 2" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        </div>
        <div class="data-grid">
            <div class="data-item"><label>Tipo</label><p>Persona {{tipo}}</p></div>
            <div class="data-item"><label>Nombre</label><p>{{name}}</p></div>
            <div class="data-item"><label>RFC</label><p>{{rfc}}</p></div>
            <div class="data-item"><label>Fecha</label><p>{{date}} {{estatus}}</p></div>
            <div class="data-item"><label>Régimen</label><p>{{regimen}}</p></div>
        </div>
        {{warningMessage}}
        <div class="sat-actions">
            <button class="small-btn" id="viewSatDataBtn">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 10V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 2H14V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.3335 6.66667L14.0002 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Ver datos completos del SAT
            </button>
        </div>
        <div id="sat-data-loading" style="display: none;">
            <div class="loading-container">
                <div class="spinner"></div>
                <p>Obteniendo información del SAT...</p>
            </div>
        </div>
    </div>
`;

export const loadingTemplate = `
    <div id="pdf-loading">
        <div class="loading-container">
            <div class="spinner"></div>
            <p>Analizando documento...</p>
        </div>
    </div>
`;