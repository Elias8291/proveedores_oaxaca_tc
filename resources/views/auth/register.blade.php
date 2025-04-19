
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

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
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
    
        <div id="pdf-data-preview">
            <div class="success-card" id="pdf-data-card">
                <!-- HEADER SECTION -->
                <div class="success-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.7088 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 4L12 14.01L9 11.01" stroke="#9F1F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h3 id="document-status">DOCUMENTO</h3>
                        <div class="warning-badge" id="warning-badge" style="display: none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            VENCIDO
                        </div>
                    </div>
                    <div class="sat-actions">
                        <button class="small-btn" id="viewSatDataBtn" disabled>VER MAS DATOS SAT</button>
                    </div>
                </div>
    
                <!-- DATA FIELDS -->
                <div class="name-display">
                    <p><strong id="label-nombre"></strong> <span id="nombre"></span></p>
                    <p><strong>TIPO DE PERSONA:</strong> <span id="tipo-persona"></span></p>
                    <p><strong>RFC:</strong> <span id="rfc"></span></p>
                    <p><strong>CÓDIGO POSTAL:</strong> <span id="cp"></span></p>
                    <div class="address-section">
                        <p><strong>DIRECCIÓN:</strong> <span id="direccion"></span></p>
                    </div>
                </div>
    
                <!-- EMAIL SECTION -->
                <div class="email-section">
                    <p class="name-display"><strong>CORREO ELECTRÓNICO:</strong></p>
                    <input type="email" id="email-input" class="email-input" placeholder="INGRESE CORREO">
                </div>
    
                <!-- LOADING SECTION -->
                <div id="sat-data-loading" style="display: none;">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    
        <button type="button" class="btn" id="registerBtn">Registrarse</button>
    </div>

    @push('scripts')
    <script type="module">
        const step1 = document.getElementById('registerFormStep1');
        const step2 = document.getElementById('registerFormStep2');
        const nextBtn = document.getElementById('nextToStep2Btn');
        const backBtnStep2 = document.getElementById('backFromRegisterStep2Btn');
        const backBtnStep1 = document.getElementById('backFromRegisterStep1Btn');
        const fileInput = document.getElementById('register-file');
        const registerBtn = document.getElementById('registerBtn');
        const registerForm = document.getElementById('registerForm');
    
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
    
        registerBtn.addEventListener('click', () => {
            const formData = new FormData(registerForm);
            const nombre = document.getElementById('nombre').textContent.trim();
            const rfc = document.getElementById('rfc').textContent.trim();
            let tipoPersona = document.getElementById('tipo-persona').textContent.trim();
            const codigoPostal = document.getElementById('cp').textContent.trim();
            const email = document.getElementById('email-input').value.trim();
    
            // Normalize tipo_persona to match database enum (Física or Moral)
            tipoPersona = tipoPersona.toLowerCase() === 'física' ? 'Física' : tipoPersona.toLowerCase() === 'moral' ? 'Moral' : tipoPersona;
    
            // Convert codigo_postal to integer
            const codigoPostalInt = parseInt(codigoPostal, 10);
            if (isNaN(codigoPostalInt)) {
                alert('El código postal debe ser un número válido.');
                return;
            }
    
            // Validate email (if required)
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Por favor, ingrese un correo electrónico válido.');
                return;
            }
    
            // Validate tipo_persona
            if (!['Física', 'Moral'].includes(tipoPersona)) {
                alert('El tipo de persona debe ser "Física" o "Moral".');
                return;
            }
    
            // Append normalized data to FormData
            formData.append('nombre', nombre);
            formData.append('rfc', rfc);
            formData.append('tipo_persona', tipoPersona);
            formData.append('codigo_postal', codigoPostalInt);
            formData.append('email', email);
    
            // Debug: Log form data
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
    
            // Get CSRF token with fallback
            let token;
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                token = metaTag.getAttribute('content');
            } else {
                token = '{{ csrf_token() }}';
                console.warn('CSRF meta tag not found, using fallback token');
            }
    
            if (!token) {
                alert('Error: No se encontró el token CSRF. Por favor, recarga la página.');
                return;
            }
    
            fetch('{{ route('register') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Response Body:', text);
                        throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Error al registrar: ' + (data.message || 'Por favor, intenta de nuevo.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al registrar: ' + error.message);
            });
        });
    </script>
    @endpush