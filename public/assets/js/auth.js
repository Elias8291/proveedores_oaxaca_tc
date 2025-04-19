document.addEventListener('DOMContentLoaded', function() {
    const formsContainer = document.querySelector('.forms-container');
    const welcomeForm = document.getElementById('welcomeForm');
    const loginForm = document.getElementById('loginForm');
    const forgotForm = document.getElementById('forgotForm');
    const registerFormStep1 = document.getElementById('registerFormStep1');
    const registerFormStep2 = document.getElementById('registerFormStep2');
    const passwordForm = document.getElementById('passwordForm');

    const navButtons = {
        goToLoginBtn: 'loginForm',
        goToRegisterBtn: 'registerFormStep1',
        backFromLoginBtn: 'welcomeForm',
        goToRegisterFromLoginBtn: 'registerFormStep1',
        forgotPasswordBtn: 'forgotForm',
        backFromForgotBtn: 'loginForm',
        backFromRegisterStep1Btn: 'welcomeForm',
        backFromRegisterStep2Btn: 'registerFormStep1',
        nextToStep2Btn: 'registerFormStep2',
        backFromPasswordFormBtn: 'loginForm'
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

        // Reset all input fields
        const inputs = formElement.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else if (input.type !== 'hidden') { // Skip hidden inputs like CSRF token
                input.value = '';
            }
        });

        // Remove error messages and error classes
        const errorMessages = formElement.querySelectorAll('.error-message, .alert-danger, .invalid-feedback');
        errorMessages.forEach(error => error.remove());
        const errorInputs = formElement.querySelectorAll('.error, .is-invalid');
        errorInputs.forEach(input => input.classList.remove('error', 'is-invalid'));

        // Form-specific resets
        if (formElement.id === 'registerFormStep1' || formElement.id === 'registerFormStep2') {
            // Clear PDF data fields
            ['pdf-name', 'pdf-rfc', 'pdf-date', 'pdf-regimen', 'pdf-qr-url', 'nombre', 'tipo-persona', 'rfc', 'cp', 'direccion'].forEach(id => {
                const element = document.getElementById(id);
                if (element) element.textContent = '';
            });
            // Reset email input in registerFormStep2
            const emailInput = document.getElementById('email-input');
            if (emailInput) emailInput.value = '';
            // Reset warning badge and document status
            const warningBadge = document.getElementById('warning-badge');
            if (warningBadge) warningBadge.style.display = 'none';
            const documentStatus = document.getElementById('document-status');
            if (documentStatus) documentStatus.textContent = 'DOCUMENTO';
            cleanFileUpload();
        }

        if (formElement.id === 'passwordForm') {
            // Clear password inputs
            const passwordInputs = formElement.querySelectorAll('input[type="password"]');
            passwordInputs.forEach(input => input.value = '');
            // Remove session error messages
            const sessionErrors = formElement.querySelectorAll('.alert.alert-danger');
            sessionErrors.forEach(error => error.remove());
        }

        if (formElement.id === 'loginForm') {
            // Clear login inputs
            const loginInputs = formElement.querySelectorAll('input[type="email"], input[type="password"]');
            loginInputs.forEach(input => input.value = '');
        }

        if (formElement.id === 'forgotForm') {
            // Clear email input
            const emailInput = formElement.querySelector('input[type="email"]');
            if (emailInput) emailInput.value = '';
        }
    }

    function resetAllForms() {
        const allForms = [welcomeForm, loginForm, forgotForm, registerFormStep1, registerFormStep2, passwordForm];
        allForms.forEach(form => {
            if (form) resetForm(form);
        });
    }

    function hasLoginErrors() {
        const errorElements = loginForm.querySelectorAll('.error-message, .alert-danger');
        return errorElements.length > 0;
    }

    function hasPasswordResetToken() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.has('token');
    }

    function initializeForms() {
        // Remove active class from all forms
        const allForms = [welcomeForm, loginForm, forgotForm, registerFormStep1, registerFormStep2, passwordForm];
        allForms.forEach(form => {
            if (form) form.classList.remove('active', 'slide-in');
        });

        // Reset all forms to ensure clean state
        resetAllForms();

        // Activate the appropriate form
        if (hasPasswordResetToken()) {
            activateForm(passwordForm);
        } else if (hasLoginErrors()) {
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
                // Reset all forms if navigating to welcomeForm
                if (formToShow.id === 'welcomeForm') {
                    resetAllForms();
                }
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
                            return; // Prevent navigation if no file is uploaded
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
        } else if (hasPasswordResetToken()) {
            activateForm(passwordForm, true);
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