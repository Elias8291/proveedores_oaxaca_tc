document.addEventListener('DOMContentLoaded', function() {
    const formsContainer = document.querySelector('.forms-container');
    const welcomeForm = document.getElementById('welcomeForm');
    const loginForm = document.getElementById('loginForm');
    const forgotForm = document.getElementById('forgotForm');
    const registerFormStep1 = document.getElementById('registerFormStep1');
    const registerFormStep2 = document.getElementById('registerFormStep2');

    const navButtons = {
        goToLoginBtn: 'loginForm',
        goToRegisterBtn: 'registerFormStep1',
        backFromLoginBtn: 'welcomeForm',
        goToRegisterFromLoginBtn: 'registerFormStep1',
        forgotPasswordBtn: 'forgotForm',
        backFromForgotBtn: 'loginForm',
        backFromRegisterStep1Btn: 'welcomeForm',
        backFromRegisterStep2Btn: 'registerFormStep1',
        nextToStep2Btn: 'registerFormStep2'
    };

    function cleanFileUpload() {
        const fileInput = document.getElementById('register-file');
        const customUploader = document.querySelector('.custom-file-upload');
        if (fileInput) fileInput.value = '';
        if (customUploader) {
            customUploader.classList.remove('has-file');
            const span = customUploader.querySelector('span');
            if (span) span.textContent = 'Subir archivo PDF';
        }
    }

    function resetForm(formElement) {
        if (!formElement) return;
        const inputs = formElement.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });
        if (formElement.id === 'registerFormStep1' || formElement.id === 'registerFormStep2') {
            ['pdf-name', 'pdf-rfc', 'pdf-date', 'pdf-regimen', 'pdf-qr-url'].forEach(id => {
                const element = document.getElementById(id);
                if (element) element.textContent = '';
            });
            cleanFileUpload();
        }
    }

    function hasLoginErrors() {
        const errorElements = loginForm.querySelectorAll('.error-message, .alert-danger');
        return errorElements.length > 0;
    }

    function initializeForms() {
        if (hasLoginErrors()) {
            activateForm(loginForm);
        } else {
            activateForm(welcomeForm);
        }
    }

    function activateForm(formToShow, isBackNavigation = false) {
        if (!formToShow) return;
        const currentActive = document.querySelector('.form-page.active');
        if (currentActive) {
            if (isBackNavigation) {
                resetForm(currentActive);
                const errorMessages = currentActive.querySelectorAll('.error-message, .alert-danger');
                errorMessages.forEach(error => error.remove());
                const errorInputs = currentActive.querySelectorAll('.error');
                errorInputs.forEach(input => input.classList.remove('error'));
            }
            currentActive.classList.remove('active', 'slide-in', 'fade-in', 'flip-in');
            currentActive.classList.add('slide-out');
            setTimeout(() => {
                currentActive.classList.remove('slide-out');
            }, 350);
        }
        setTimeout(() => {
            formToShow.classList.add('active', 'slide-in');
            if (formsContainer) {
                formsContainer.style.height = `${formToShow.scrollHeight}px`;
            }
            const container = document.querySelector('.container');
            if (formToShow.id === 'registerFormStep2') {
                container.classList.add('show-pdf-preview');
            } else {
                container.classList.remove('show-pdf-preview');
            }
            setTimeout(() => {
                formToShow.classList.remove('slide-in');
            }, 350);
        }, 10);
    }

    function setupNavigation() {
        Object.keys(navButtons).forEach(buttonId => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (buttonId === 'nextToStep2Btn') {
                        const fileInput = document.getElementById('register-file');
                        if (!fileInput || fileInput.files.length === 0) {
                            alert('Por favor, sube un archivo PDF.');
                            return;
                        }
                        const event = new CustomEvent('processPDF', { detail: fileInput.files[0] });
                        document.dispatchEvent(event);
                    }
                    const targetForm = document.getElementById(navButtons[buttonId]);
                    const isBackButton = buttonId.includes('backFrom') || buttonId.includes('goToRegisterFromLogin');
                    activateForm(targetForm, isBackButton);
                    history.pushState({ form: buttonId }, '', window.location.pathname);
                });
            }
        });
    }

    function setupFileInput() {
        const fileInput = document.getElementById('register-file');
        const customFileUpload = document.querySelector('.custom-file-upload');
        if (fileInput && customFileUpload) {
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    customFileUpload.classList.add('has-file');
                    customFileUpload.querySelector('span').textContent = fileInput.files[0].name;
                } else {
                    cleanFileUpload();
                }
            });
        }
    }

    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.form) {
            const targetForm = document.getElementById(navButtons[e.state.form]);
            activateForm(targetForm, true);
        } else {
            activateForm(welcomeForm, true);
        }
    });

    initializeForms();
    setupNavigation();
    setupFileInput();

    window.addEventListener('resize', function() {
        const activeForm = document.querySelector('.form-page.active');
        if (activeForm && formsContainer) {
            formsContainer.style.height = `${activeForm.scrollHeight}px`;
        }
    });
});