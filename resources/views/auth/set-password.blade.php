<div class="form-page password-form" id="passwordForm">
    <button class="back-btn" id="backFromPasswordFormBtn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Atrás
    </button>

    <img src="{{ asset('assets/images/welcome/administration-secretariat-logo.png') }}" alt="Logo" class="logo-img">
    <h1>Establecer Contraseña</h1>
    <p>Configura una nueva contraseña para tu cuenta en el <span class="system-name">Padrón de Proveedores de Oaxaca</span></p>

    <form method="POST" action="{{ route('password.set') }}" id="passwordForm">
        @csrf
        <input type="hidden" name="token" value="{{ request()->query('token') }}">

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="input-group">
            <label for="password">Contraseña*</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password-confirm">Confirmar Contraseña*</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn">Establecer Contraseña</button>
    </form>
</div>

@push('scripts')
    <script type="module">
        const backBtn = document.getElementById('backFromPasswordFormBtn');
        const passwordForm = document.getElementById('passwordForm');
        const modal = document.getElementById('registrationModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalOkBtn = document.getElementById('modalOkBtn');
        const modalCloseBtn = document.getElementById('modalCloseBtn');

        function showModal(title, message, isSuccess = true) {
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            modal.style.display = 'block';
            modalTitle.style.color = isSuccess ? '#2e7d32' : '#d32f2f';
            modalOkBtn.focus();
        }

        function hideModal() {
            modal.style.display = 'none';
        }

        modalOkBtn.addEventListener('click', hideModal);
        modalCloseBtn.addEventListener('click', hideModal);

        backBtn.addEventListener('click', () => {
            window.history.back();
        });

        passwordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(passwordForm);
            let token;
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                token = metaTag.getAttribute('content');
            } else {
                token = '{{ csrf_token() }}';
                console.warn('CSRF meta tag not found, using fallback token');
            }

            if (!token) {
                showModal('Error', 'No se encontró el token CSRF. Por favor, recarga la página.', false);
                return;
            }

            fetch('{{ route('password.set') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || `HTTP error! Status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showModal('Éxito', data.message || 'Contraseña establecida con éxito. Por favor, inicia sesión.', true);
                    modalOkBtn.onclick = () => {
                        hideModal();
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    };
                } else {
                    showModal('Error', data.message || 'Error al establecer la contraseña. Por favor, intenta de nuevo.', false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('Error', error.message || 'Error al establecer la contraseña. Por favor, intenta de nuevo.', false);
            });
        });
    </script>
@endpush