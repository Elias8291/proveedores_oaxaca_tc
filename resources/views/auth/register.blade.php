
    <div class="form-page register-form active" id="registerFormStep1">
        <button class="back-btn" id="backFromRegisterStep1Btn">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Atrás
        </button>

        <img src="{{ asset('assets/images/welcome/administration-secretariat-logo.png') }}" alt="Logo" class="logo-img">
        <h1>Regístrate</h1>
        <p>Registro en el <span class="system-name">Padrón de Proveedores de Oaxaca</span></p>

        <form method="POST" enctype="multipart/form-data" id="registerForm">
            @csrf
            <div class="input-group">
                <div class="file-input-header">
                    <label for="register-file">Constancia del SAT (PDF)*</label>
                    <button type="button" class="small-btn outline" id="viewExampleBtnStep1">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 10V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 2H14V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.3335 6.66667L14.0002 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Ver ejemplo
                    </button>
                </div>
                <label class="custom-file-upload" for="register-file">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 2V8H20" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 13H8" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 17H8" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 9H9H8" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Subir archivo PDF</span>
                    <small>Tamaño máximo: 5MB</small>
                </label>
                <input type="file" id="register-file" name="sat_file" accept="application/pdf" required>
            </div>

            <button type="button" class="btn" id="nextToStep2Btn">Siguiente</button>
        </form>
    </div>

    <div class="form-page register-form" id="registerFormStep2">
        <button class="back-btn" id="backFromRegisterStep2Btn">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Atrás
        </button>

        <img src="{{ asset('assets/images/welcome/administration-secretariat-logo.png') }}" alt="Logo" class="logo-img">
        <h1>Datos del PDF</h1>
        <div id="pdf-data-preview"></div>

        <button type="submit" class="btn" id="registerBtn" form="registerForm">Registrarse</button>
    </div>

    @push('scripts')
    <script type="module">
        const step1 = document.getElementById('registerFormStep1');
        const step2 = document.getElementById('registerFormStep2');
        const nextBtn = document.getElementById('nextToStep2Btn');
        const backBtnStep2 = document.getElementById('backFromRegisterStep2Btn');
        const backBtnStep1 = document.getElementById('backFromRegisterStep1Btn');
        const fileInput = document.getElementById('register-file');

        nextBtn.addEventListener('click', () => {
            const file = fileInput.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('El archivo excede el tamaño máximo de 5MB.');
                    return;
                }
                step1.classList.remove('active');
                step2.classList.add('active');
                document.dispatchEvent(new CustomEvent('processPDF', { detail: file }));
            } else {
                alert('Por favor, sube un archivo PDF.');
            }
        });

        backBtnStep2.addEventListener('click', () => {
            step2.classList.remove('active');
            step1.classList.add('active');
        });

        backBtnStep1.addEventListener('click', () => {
            window.history.back();
        });

        document.getElementById('viewExampleBtnStep1').addEventListener('click', () => {
            window.open('{{ asset('assets/pdf/ejemplo_sat.pdf') }}', '_blank');
        });
    </script>
@endpush