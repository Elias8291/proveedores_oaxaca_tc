import { createModal, createSpinner, showError } from './utils.js';
import { scrapeSATData, showSATDataModal } from './sat-scraper.js';

window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', () => {
    async function extractQRCodeFromPDF(file) {
        const pdf = await pdfjsLib.getDocument({ data: new Uint8Array(await file.arrayBuffer()) }).promise;
        const data = { name: "", rfc: "", date: "", regimen: "", qrUrl: "", tipo: "", estatus: "" };

        for (let i = 1; i <= Math.min(3, pdf.numPages); i++) {
            const page = await pdf.getPage(i);
            const text = (await page.getTextContent()).items.map(item => item.str).join(' ');
            const rfcMatch = text.match(/([A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3})/);
            if (rfcMatch) {
                data.rfc = rfcMatch[0];
                data.tipo = data.rfc.length === 12 ? "Moral" : "Física";
            }

            const { width, height } = page.getViewport({ scale: 1 });
            const canvas = Object.assign(document.createElement('canvas'), { width, height });
            await page.render({ canvasContext: canvas.getContext('2d'), viewport: page.getViewport({ scale: 1 }) }).promise;
            const qrCode = jsQR(canvas.getContext('2d').getImageData(0, 0, width, height).data, width, height);
            if (qrCode) {
                data.qrUrl = qrCode.data;
                if (!data.qrUrl.includes('siat.sat.gob.mx')) throw new Error('QR no válido del SAT.');
                const dateMatch = text.match(/(\d{2}\/\d{2}\/\d{4})/g);
                if (dateMatch) {
                    data.date = dateMatch[dateMatch.length - 1];
                    data.estatus = new Date(data.date.split('/').reverse().join('-')) < new Date().setHours(0, 0, 0, 0) ? "Vencido" : "Vigente";
                }
                data.name = text.match(/NOMBRE(?:\sDEL\sCONTRIBUYENTE)?:\s*([A-ZÀ-ÚÑ&\s]+)/i)?.[1]?.trim() || "";
                data.regimen = text.match(/RÉGIMEN(?:\sFISCAL)?:\s*([A-ZÀ-ÚÑ\s]+)/i)?.[1]?.trim() || "";
                break;
            }
        }
        if (!data.qrUrl || !data.rfc) throw new Error('QR o RFC no encontrados.');
        return data;
    }

    function updatePDFDataPreview(data, satData) {
        const preview = document.getElementById("pdf-data-preview");
        if (!preview) return;
        const isExpired = data.estatus === "Vencido";
        const nombre =
            data.tipo === "Moral"
                ? satData.razonSocial || data.name
                : satData.nombreCompleto || data.name;
        const emails = Array.isArray(satData.email)
            ? satData.email
            : satData.email
            ? [satData.email]
            : [];
    
        preview.innerHTML = `
            <div class="success-card ${isExpired ? 'expired' : ''}">
                <!-- HEADER SECTION -->
                <div class="success-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.7088 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 4L12 14.01L9 11.01" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h3>DOCUMENTO ${isExpired ? 'VENCIDO' : 'VÁLIDO'}</h3>
                        ${
                            isExpired
                                ? `
                                    <div class="warning-badge">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        VENCIDO
                                    </div>
                                `
                                : ''
                        }
                    </div>
                    <div class="sat-actions">
                        <button class="small-btn" id="viewSatDataBtn">VER MAS DATOS SAT</button>
                    </div>
                </div>
    
                <!-- ALL DATA IN NAME-DISPLAY SECTION -->
                <div class="name-display">
                    <p><strong>${
                        data.tipo.toUpperCase() === 'MORAL' ? 'RAZÓN SOCIAL' : 'NOMBRE'
                    }:</strong> ${nombre.toUpperCase()}</p>
                    <p><strong>TIPO DE PERSONA:</strong> ${data.tipo.toUpperCase()}</p>
                    <p><strong>RFC:</strong> ${data.rfc}</p>
                    ${
                        satData.cp
                            ? `<p><strong>CÓDIGO POSTAL:</strong> ${satData.cp}</p>`
                            : ''
                    }
                    ${
                        satData.regimen
                            ? `<p><strong>RÉGIMEN FISCAL:</strong> ${satData.regimen.toUpperCase()}</p>`
                            : ''
                    }
                    ${
                        data.date
                            ? `<p><strong>FECHA DE EMISIÓN:</strong> ${data.date}</p>`
                            : ''
                    }
                    ${
                        satData.nombreVialidad
                            ? `
                                <div class="address-section">
                                    <p><strong>DIRECCIÓN:</strong>
                                        ${satData.nombreVialidad.toUpperCase()}
                                        ${satData.numeroExterior ? satData.numeroExterior : ''}
                                        ${satData.numeroInterior ? `INT. ${satData.numeroInterior}` : ''}
                                        ${satData.colonia ? `COL. ${satData.colonia.toUpperCase()}` : ''}
                                    </p>
                                </div>
                            `
                            : ''
                    }
                </div>
    
                <!-- EMAIL SECTION -->
                <div class="email-section">
                    <p class="name-display"><strong>CORREO ELECTRÓNICO:</strong></p>
                    <input type="email" id="email-input" class="email-input" placeholder="INGRESE CORREO" value="${emails[0] ? emails[0].toUpperCase() : ''}">
                </div>
    
                <!-- LOADING SECTION -->
                <div id="sat-data-loading" style="display:none">
                    ${createSpinner ? createSpinner() : '<div>Loading...</div>'}
                </div>
            </div>
        `;
    
        // Add event listener for SAT data button
        document
            .getElementById("viewSatDataBtn")
            .addEventListener("click", async () => {
                const loading = document.getElementById("sat-data-loading");
                const btn = document.getElementById("viewSatDataBtn");
                loading.style.display = "block";
                btn.disabled = true;
                try {
                    showSATDataModal(satData, data.qrUrl);
                } catch (error) {
                    showError(`Error al mostrar datos SAT: ${error.message}`);
                } finally {
                    loading.style.display = "none";
                    btn.disabled = false;
                }
            });
    
        // Optional: Add validation for the email input on blur or form submission
        const emailInput = document.getElementById("email-input");
        emailInput.addEventListener("blur", () => {
            if (emailInput.value && !validateEmail(emailInput.value)) {
                showError("Por favor ingrese un correo electrónico válido.");
            }
        });
    }

    const validateEmail = email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email).toLowerCase());

    document.addEventListener('processPDF', async e => {
        const loading = createModal({ html: createSpinner() });
        try {
            const pdfData = await extractQRCodeFromPDF(e.detail);
            const satData = await scrapeSATData(pdfData.qrUrl);
            updatePDFDataPreview(pdfData, satData);
        } catch (error) {
            showError(error.message);
        } finally {
            document.body.removeChild(loading);
        }
    });
});