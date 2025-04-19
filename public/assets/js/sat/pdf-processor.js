import { createModal, createSpinner, showError } from './utils.js';
import { scrapeSATData, showSATDataModal } from './sat-scraper.js';

// Set PDF.js worker source
window.pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

// Extract data from PDF
async function extractQRCodeFromPDF(file) {
    try {
        const pdf = await pdfjsLib.getDocument({ data: new Uint8Array(await file.arrayBuffer()) }).promise;
        const data = { name: '', rfc: '', date: '', regimen: '', qrUrl: '', tipo: '', estatus: '' };

        for (let i = 1; i <= Math.min(3, pdf.numPages); i++) {
            const page = await pdf.getPage(i);
            const text = (await page.getTextContent()).items.map((item) => item.str).join(' ');

            // Extract RFC
            const rfcMatch = text.match(/([A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3})/);
            if (rfcMatch) {
                data.rfc = rfcMatch[0];
                data.tipo = data.rfc.length === 12 ? 'Moral' : 'Física';
            }

            // Extract QR code
            const { width, height } = page.getViewport({ scale: 1 });
            const canvas = Object.assign(document.createElement('canvas'), { width, height });
            await page.render({ canvasContext: canvas.getContext('2d'), viewport: page.getViewport({ scale: 1 }) }).promise;
            const qrCode = jsQR(canvas.getContext('2d').getImageData(0, 0, width, height).data, width, height);
            if (qrCode) {
                data.qrUrl = qrCode.data;
                if (!data.qrUrl.includes('siat.sat.gob.mx')) throw new Error('Invalid SAT QR code.');

                // Extract date and status
                const dateMatch = text.match(/(\d{2}\/\d{2}\/\d{4})/g);
                if (dateMatch) {
                    data.date = dateMatch[dateMatch.length - 1];
                    const [day, month, year] = data.date.split('/');
                    data.estatus =
                        new Date(`${year}-${month}-${day}`) < new Date().setHours(0, 0, 0, 0) ? 'Vencido' : 'Vigente';
                }

                // Extract name and regimen
                data.name = text.match(/NOMBRE(?:\sDEL\sCONTRIBUYENTE)?:\s*([A-ZÀ-ÚÑ&\s]+)/i)?.[1]?.trim() || '';
                data.regimen = text.match(/RÉGIMEN(?:\sFISCAL)?:\s*([A-ZÀ-ÚÑ\s]+)/i)?.[1]?.trim() || '';
                break;
            }
        }

        if (!data.qrUrl || !data.rfc) throw new Error('QR code or RFC not found.');
        return data;
    } catch (error) {
        throw new Error(`PDF processing failed: ${error.message}`);
    }
}

// Update UI with PDF and SAT data
function updatePDFDataPreview(pdfData, satData) {
    const isExpired = pdfData.estatus === 'Vencido';
    const nombre = pdfData.tipo === 'Moral' ? satData.razonSocial || pdfData.name : satData.nombreCompleto || pdfData.name;

    // Update document status
    const documentStatus = document.getElementById('document-status');
    const warningBadge = document.getElementById('warning-badge');
    const pdfDataCard = document.getElementById('pdf-data-card');
    if (documentStatus) documentStatus.textContent = `DOCUMENTO ${isExpired ? 'VENCIDO' : 'VÁLIDO'}`;
    if (warningBadge) warningBadge.style.display = isExpired ? 'inline-flex' : 'none';
    if (pdfDataCard) pdfDataCard.classList.toggle('expired', isExpired);

    // Update fields
    const fields = {
        'label-nombre': pdfData.tipo === 'Moral' ? 'RAZÓN SOCIAL:' : 'NOMBRE:',
        nombre: nombre.toUpperCase() || 'No disponible',
        'tipo-persona': pdfData.tipo.toUpperCase() || 'No disponible',
        rfc: pdfData.rfc || 'No disponible',
        cp: satData.cp || 'No disponible',
        direccion: [
            satData.nombreVialidad?.toUpperCase(),
            satData.numeroExterior,
            satData.numeroInterior ? `INT. ${satData.numeroInterior}` : '',
            satData.colonia ? `COL. ${satData.colonia.toUpperCase()}` : '',
        ]
            .filter(Boolean)
            .join(' ') || 'No disponible',
        'email-input': satData.email?.toUpperCase() || '',
    };

    Object.entries(fields).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) {
            if (element.tagName === 'INPUT') element.value = value;
            else element.textContent = value;
        }
    });

    // Enable SAT data button and attach event listener
    const viewSatDataBtn = document.getElementById('viewSatDataBtn');
    if (viewSatDataBtn) {
        viewSatDataBtn.disabled = false;
        viewSatDataBtn.addEventListener('click', async () => {
            const loading = document.getElementById('sat-data-loading');
            if (loading) loading.style.display = 'block';
            viewSatDataBtn.disabled = true;
            try {
                showSATDataModal(satData, pdfData.qrUrl);
            } catch (error) {
                showError(`Failed to display SAT data: ${error.message}`);
            } finally {
                if (loading) loading.style.display = 'none';
                viewSatDataBtn.disabled = false;
            }
        });
    }

    // Add email validation
    const emailInput = document.getElementById('email-input');
    if (emailInput) {
        emailInput.addEventListener('blur', () => {
            if (emailInput.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.toLowerCase())) {
                showError('Please enter a valid email address.');
            }
        });
    }
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', () => {
    const step1 = document.getElementById('registerFormStep1');
    const step2 = document.getElementById('registerFormStep2');
    const nextBtn = document.getElementById('nextToStep2Btn');
    const backBtnStep2 = document.getElementById('backFromRegisterStep2Btn');
    const backBtnStep1 = document.getElementById('backFromRegisterStep1Btn');
    const fileInput = document.getElementById('register-file');
    const viewExampleBtn = document.getElementById('viewExampleBtnStep1');

    nextBtn?.addEventListener('click', async () => {
        const file = fileInput?.files[0];
        if (!file) return alert('Please upload a PDF file.');
        if (file.size > 5 * 1024 * 1024) return alert('File exceeds the maximum size of 5MB.');

        const loading = createModal({ html: createSpinner() });
        try {
            const pdfData = await extractQRCodeFromPDF(file);
            const satData = await scrapeSATData(pdfData.qrUrl);
            step1.classList.remove('active');
            step2.classList.add('active');
            updatePDFDataPreview(pdfData, satData);
        } catch (error) {
            showError(error.message);
        } finally {
            document.body.removeChild(loading);
        }
    });

    backBtnStep2?.addEventListener('click', () => {
        step2.classList.remove('active');
        step1.classList.add('active');
    });

    backBtnStep1?.addEventListener('click', () => {
        window.history.back();
    });

    viewExampleBtn?.addEventListener('click', () => {
        window.open('{{ asset("assets/pdf/ejemplo_sat.pdf") }}', '_blank');
    });
});