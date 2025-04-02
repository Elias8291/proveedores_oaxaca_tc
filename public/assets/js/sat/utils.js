export function createModal({ className = 'modal-overlay', html, onSetup, onClose }) {
    const modal = document.createElement('div');
    modal.className = className;
    modal.innerHTML = html;
    document.body.appendChild(modal);

    const closeModal = () => {
        onClose?.();
        document.body.removeChild(modal);
    };

    modal.querySelector('.close-modal')?.addEventListener('click', closeModal);
    modal.querySelector('#closeModalBtn')?.addEventListener('click', closeModal);
    modal.addEventListener('click', e => e.target === modal && closeModal());
    onSetup?.(modal);

    return modal;
}

export function createSpinner() {
    return '<div class="spinner"></div>';
}

export function showError(message) {
    createModal({
        html: `
            <div class="modal-container">
                <div class="modal-header">
                    <h3>Error</h3>
                    <button class="icon-btn close-modal">×</button>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button class="small-btn outline" id="closeModalBtn">Cerrar</button>
                </div>
            </div>
        `
    });
}