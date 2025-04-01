document.addEventListener('DOMContentLoaded', function() {
    async function loadScripts() {
        if (window.pdfjsLib && window.jsQR) return;
        await new Promise((resolve, reject) => {
            const pdfScript = document.createElement('script');
            pdfScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js';
            pdfScript.onload = () => {
                window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
                const jsqrScript = document.createElement('script');
                jsqrScript.src = 'https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js';
                jsqrScript.onload = resolve;
                jsqrScript.onerror = reject;
                document.head.appendChild(jsqrScript);
            };
            pdfScript.onerror = reject;
            document.head.appendChild(pdfScript);
        });
    }

    function showLoading() {
        const el = document.createElement('div');
        el.id = 'pdf-loading';
        el.innerHTML = '<div class="loading-container"><div class="spinner"></div><p>Analizando documento...</p></div>';
        document.body.appendChild(el);
        return el;
    }

    function hideLoading(el) {
        el && document.body.contains(el) && document.body.removeChild(el);
    }

    function showError(message) {
        const preview = document.getElementById('pdf-data-preview');
        if (!preview) return;
        preview.innerHTML = `
            <div class="error-card">
                <div class="error-header">
                    <svg class="error-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="error-text">
                        <h3>Documento inválido</h3>
                        <p>${message}</p>
                    </div>
                </div>
                <div class="error-actions">
                    <button class="small-btn outline" id="viewDetailsBtn"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 14.6667C11.6819 14.6667 14.6667 11.6819 14.6667 8C14.6667 4.3181 11.6819 1.33333 8 1.33333C4.3181 1.33333 1.33333 4.3181 1.33333 8C1.33333 11.6819 4.3181 14.6667 8 14.6667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 10.6667V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 5.33333H8.00667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Detalles</button>
                    <button class="small-btn" id="tryAgainBtn"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.3333 2.66699C12.0697 3.22866 12.6213 3.98033 12.9253 4.83199M14 7.33366C13.9975 6.455 13.7318 5.598 13.236 4.87366M12.9333 9.83366C12.624 10.6823 12.076 11.4303 11.344 11.9877M9.33333 13.3337C8.597 13.8943 7.69767 14.1963 6.77067 14.1963C5.84367 14.1963 4.94433 13.8943 4.208 13.3337M2.66667 11.3337C2.106 10.5973 1.804 9.698 1.804 8.771C1.804 7.844 2.106 6.94466 2.66667 6.20833M2.06667 6.16699C2.376 5.31833 2.924 4.57033 3.656 4.01299M4.66667 2.66699C5.403 2.10633 6.30233 1.80433 7.22933 1.80433C8.15633 1.80433 9.05567 2.10633 9.792 2.66699" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Subir otro</button>
                </div>
            </div>
        `;
        document.getElementById('tryAgainBtn').addEventListener('click', () => {
            document.getElementById('registerFormStep2').classList.remove('active');
            document.getElementById('registerFormStep1').classList.add('active');
            document.getElementById('register-file').value = '';
        });
        document.getElementById('viewDetailsBtn').addEventListener('click', () => showErrorDetailsModal(message));
    }

    function showErrorDetailsModal(message) {
        const modal = document.createElement('div');
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal-container">
                <div class="modal-header">
                    <h3>Detalles del error</h3>
                    <button class="icon-btn close-modal">×</button>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
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
        `;
        document.body.appendChild(modal);
        const closeModal = () => document.body.removeChild(modal);
        modal.querySelector('.close-modal').addEventListener('click', closeModal);
        modal.querySelector('#closeModalBtn').addEventListener('click', closeModal);
        modal.querySelector('#viewExampleBtn').addEventListener('click', () => { closeModal(); showPDFModal(); });
        modal.addEventListener('click', e => e.target === modal && closeModal());
    }

    function showPDFModal() {
        const pdfModal = document.createElement('div');
        pdfModal.className = 'pdf-modal-overlay';
        pdfModal.innerHTML = `
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
        `;
        document.body.appendChild(pdfModal);
        const closePdfModal = () => document.body.removeChild(pdfModal);
        pdfModal.querySelector('.close-pdf-modal').addEventListener('click', closePdfModal);
        pdfModal.querySelector('#closePdfModalBtn').addEventListener('click', closePdfModal);
        const pdfUrl = 'assets/pdf/ejemplo_sat.pdf';
        const viewer = pdfModal.querySelector('#pdf-viewer-container');
        const loader = pdfModal.querySelector('.pdf-loader');
        pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
            return pdf.getPage(1).then(page => {
                loader.style.display = 'none';
                const viewport = page.getViewport({ scale: 1.0 });
                const canvas = document.createElement('canvas');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                viewer.appendChild(canvas);
                return page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
            });
        }).catch(() => {
            loader.innerHTML = '<div class="error-message"><p>No se pudo cargar el documento de ejemplo</p><button class="small-btn" onclick="window.location.reload()">Reintentar</button></div>';
        });
        pdfModal.addEventListener('click', e => e.target === pdfModal && closePdfModal());
    }

    function updatePDFDataPreview(data) {
        const preview = document.getElementById('pdf-data-preview');
        if (!preview) return;
    
        // Determine CSS class based on status
        const statusClass = data.estatus === "Vencido" ? "expired" : "valid";
    
        preview.innerHTML = `
            <div class="success-card ${statusClass}">
                <div class="success-header">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.7088 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 4L12 14.01L9 11.01" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Documento ${data.estatus === "Vencido" ? "Vencido" : "Válido"}</h3>
                    ${data.estatus === "Vencido" ? 
                        '<div class="warning-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Vencido</div>' : 
                        ''}
                    <button class="icon-btn" id="viewPdfBtn" title="Ver PDF"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 10V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 2H14V6" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.3335 6.66667L14.0002 2" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                </div>
                ${data.estatus === "Vencido" ? 
                    `<div class="warning-message">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <p>Este documento está vencido. Asegúrate de subir una constancia vigente.</p>
                    </div>` : 
                    ''}
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
    
        document.getElementById('viewPdfBtn')?.addEventListener('click', showPDFModal);
    
        document.getElementById('viewSatDataBtn').addEventListener('click', async () => {
            const loadingElement = document.getElementById('sat-data-loading');
            const button = document.getElementById('viewSatDataBtn');
    
            try {
                loadingElement.style.display = 'block';
                button.disabled = true;
    
                if (typeof window.scrapeSATData !== 'function') {
                    throw new Error('La función de scraping no está disponible');
                }
    
                const satData = await window.scrapeSATData(data.qrUrl);
    
                if (typeof window.showSATDataModal !== 'function') {
                    throw new Error('La función para mostrar el modal no está disponible');
                }
    
                window.showSATDataModal(satData, data.qrUrl);
            } catch (error) {
                showErrorDetailsModal(`No se pudo obtener información adicional del SAT: ${error.message}`);
            } finally {
                loadingElement.style.display = 'none';
                button.disabled = false;
            }
        });
    }

    async function extractQRCodeFromPDF(file) {
        const fileReader = new FileReader();
        return new Promise((resolve, reject) => {
            fileReader.onload = async () => {
                try {
                    const pdf = await pdfjsLib.getDocument({
                        data: new Uint8Array(fileReader.result),
                        cMapUrl: null,
                        cMapPacked: false
                    }).promise;
                    const data = { name: "", rfc: "", date: "", regimen: "", qrUrl: "", tipo: "", estatus: "" };
                    let qrFound = false;
                    const maxPagesToScan = Math.min(3, pdf.numPages);
                    
                    for (let i = 1; i <= maxPagesToScan && !qrFound; i++) {
                        const page = await pdf.getPage(i);
                        const textContent = await page.getTextContent();
                        const text = textContent.items.map(item => item.str).join(' ');
                        
                        const rfcMatch = text.match(/([A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3})/);
                        if (rfcMatch) {
                            data.rfc = rfcMatch[0];
                            data.tipo = data.rfc.length === 12 ? "Moral" : "Física";
                        }
                        
                        if (!qrFound) {
                            const viewport = page.getViewport({ scale: 1.0 });
                            const canvas = document.createElement('canvas');
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;
                            await page.render({
                                canvasContext: canvas.getContext('2d'),
                                viewport,
                                intent: 'print'
                            }).promise;
                            
                            const qrCode = jsQR(
                                canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height).data,
                                canvas.width,
                                canvas.height,
                                { inversionAttempts: "dontInvert" }
                            );
                            
                            if (qrCode) {
                                data.qrUrl = qrCode.data;
                                if (!data.qrUrl.includes('siat.sat.gob.mx')) {
                                    throw new Error('El código QR no pertenece al dominio oficial del SAT.');
                                }
                                qrFound = true;
                                
                                const dateMatch = text.match(/(\d{2}\/\d{2}\/\d{4})/g);
                                if (dateMatch && dateMatch.length > 0) {
                                    data.date = dateMatch[dateMatch.length - 1];
                                    const docDate = new Date(data.date.split('/').reverse().join('-'));
                                    const today = new Date();
                                    today.setHours(0, 0, 0, 0);
                                    data.estatus = docDate < today ? "Vencido" : "Vigente";
                                }
                                
                                if (!data.name) {
                                    const nameMatch = text.match(/NOMBRE(?:\sDEL\sCONTRIBUYENTE)?:\s*([A-ZÀ-ÚÑ&\s]+)/i);
                                    data.name = nameMatch?.[1]?.trim() || "";
                                }
                                
                                if (!data.regimen) {
                                    const regimenMatch = text.match(/RÉGIMEN(?:\sFISCAL)?:\s*([A-ZÀ-ÚÑ\s]+)/i);
                                    data.regimen = regimenMatch?.[1]?.trim() || "";
                                }
                            }
                        }
                    }
                    
                    if (!data.qrUrl) throw new Error('No se encontró un código QR válido en el documento.');
                    if (!data.rfc) throw new Error('No se pudo identificar el RFC en el documento.');
                    
                    resolve(data);
                } catch (error) {
                    reject(error);
                }
            };
            fileReader.onerror = () => reject(new Error('Error al leer el archivo.'));
            fileReader.readAsArrayBuffer(file);
        });
    }

    document.addEventListener('processPDF', async e => {
        const loading = showLoading();
        try {
            await loadScripts();
            const data = await extractQRCodeFromPDF(e.detail);
            updatePDFDataPreview(data);
        } catch (error) {
            showError(error.message);
        } finally {
            hideLoading(loading);
        }
    });

    document.head.appendChild(Object.assign(document.createElement('style'), {
        textContent: `
            #pdf-loading{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.95);display:flex;justify-content:center;align-items:center;z-index:1000;backdrop-filter:blur(2px)}.loading-container{text-align:center;padding:24px;background:white;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.1);max-width:300px;width:100%}.spinner{width:40px;height:40px;border:3px solid rgba(159,31,79,0.1);border-top:3px solid #9F1F4F;border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 16px}@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}#pdf-loading p{color:#4B5563;font-size:0.9rem;margin:0}.error-card{background:#FFF5F7;border:1px solid #FED7E2;border-radius:8px;padding:12px;font-size:0.8rem}.error-header{display:flex;align-items:flex-start;gap:8px;margin-bottom:8px}.error-icon{flex-shrink:0;margin-top:2px;color:#9F1F4F}.error-text h3{margin:0;color:#9F1F4F;font-size:0.85rem;font-weight:600}.error-text p{margin:4px 0 0;color:#6B7280;font-size:0.8rem;line-height:1.4}.error-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:8px}.small-btn{height:28px;padding:0 12px;font-size:0.75rem;border-radius:6px;border:1px solid #9F1F4F;background:#9F1F4F;color:white;cursor:pointer;transition:all 0.2s;display:inline-flex;align-items:center;gap:6px;font-weight:500}.small-btn:hover{background:#7A1740;border-color:#7A1740}.small-btn.outline{background:transparent;color:#9F1F4F;border-color:#E5E7EB}.small-btn.outline:hover{background:rgba(159,31,79,0.05);border-color:#D1D5DB}.icon-btn{width:28px;height:28px;display:inline-flex;align-items:center;justify-content:center;background:none;border:none;border-radius:6px;color:#9F1F4F;cursor:pointer;transition:all 0.2s;padding:0}.icon-btn:hover{background:rgba(159,31,79,0.1)}.success-card{background:white;border:1px solid #E5E7EB;border-radius:8px;padding:12px}.success-card.expired{border-color:#FECACA;background-color:#FEF2F2}.success-header{display:flex;align-items:center;gap:8px;margin-bottom:12px}.success-header h3{margin:0;font-size:0.9rem;color:#9F1F4F;font-weight:600;flex-grow:1}.success-header svg{color:#9F1F4F}.warning-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background-color:#FEE2E2;color:#B91C1C;border-radius:9999px;font-size:0.75rem;font-weight:500}.warning-badge svg{color:#B91C1C}.warning-message{display:flex;align-items:flex-start;gap:8px;padding:8px;background-color:#FEF2F2;border-radius:6px;margin-top:8px;margin-bottom:12px}.warning-message svg{flex-shrink:0;color:#B91C1C;margin-top:2px}.warning-message p{margin:0;font-size:0.8rem;color:#B91C1C;line-height:1.4}.data-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}.data-item{margin-bottom:4px}.data-item.full-width{grid-column:span 2}.data-item label{display:block;font-size:0.7rem;color:#6B7280;margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px}.data-item p{margin:0;font-size:0.8rem;color:#111827;font-weight:500;word-break:break-word}.data-item p.link{color:#9F1F4F;text-decoration:underline;cursor:pointer}.data-item p.link:hover{color:#7A1740}.modal-overlay{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);display:flex;justify-content:center;align-items:center;z-index:2000;animation:fadeIn 0.2s ease-out}@keyframes fadeIn{from{opacity:0}to{opacity:1}}.modal-container{background:white;border-radius:8px;width:90%;max-width:400px;overflow:hidden;animation:slideUp 0.3s ease-out}@keyframes slideUp{from{transform:translateY(20px)}to{transform:translateY(0)}}.modal-header{padding:12px 16px;border-bottom:1px solid #F3F4F6;display:flex;justify-content:space-between;align-items:center}.modal-header h3{margin:0;font-size:0.95rem;color:#111827}.modal-body{padding:16px}.modal-body p{margin:0 0 12px;font-size:0.85rem;color:#4B5563;line-height:1.5}.tip-box{display:flex;gap:8px;padding:10px;background:#F9FAFB;border-radius:6px;font-size:0.8rem;color:#6B7280;line-height:1.5}.tip-box svg{flex-shrink:0;color:#9F1F4F}.modal-footer{padding:12px 16px;border-top:1px solid #F3F4F6;display:flex;justify-content:flex-end;gap:8px}.pdf-modal-overlay{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.7);display:flex;justify-content:center;align-items:center;z-index: the's2100;animation:fadeIn 0.2s ease-out}.pdf-modal-container{background:white;border-radius:8px;width:90%;max-width:800px;max-height:90vh;display:flex;flex-direction:column;overflow:hidden;animation:slideUp 0.3s ease-out}.pdf-modal-header{padding:12px 16px;border-bottom:1px solid #F3F4F6;display:flex;justify-content:space-between;align-items:center}.pdf-modal-header h3{margin:0;font-size:1rem;color:#111827}.pdf-modal-body{padding:16px;overflow-y:auto;flex-grow:1;position:relative}#pdf-viewer-container{display:flex;flex-direction:column;gap:20px}#pdf-viewer-container canvas{width:100%;height:auto;border:1px solid #E5E7EB;border-radius:4px;box-shadow:0 2px 4px rgba(0,0,0,0.05)}.pdf-loader{position:absolute;top:0;left:0;right:0;bottom:0;display:flex;flex-direction:column;justify-content:center;align-items:center;background:rgba(255,255,255,0.9)}.pdf-spinner{width:40px;height:40px;border:3px solid rgba(159,31,79,0.1);border-top:3px solid #9F1F4F;border-radius:50%;animation:spin 1s linear infinite;margin-bottom:12px}.pdf-loader p{margin:0;color:#4B5563;font-size:0.9rem}.pdf-modal-footer{padding:12px 16px;border-top:1px solid #F3F4F6;display:flex;justify-content:flex-end}
        `
    }));

    document.getElementById('viewExampleBtnStep1').addEventListener('click', showPDFModal);
});