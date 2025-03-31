<div class="form-page login-form" id="loginForm">
    <button class="back-btn" id="backFromLoginBtn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        Atrás
    </button>

    <img src="{{ asset('assets/images/welcome/administration-secretariat-logo.png') }}" alt="Logo" class="logo-img">
    <h1>Iniciar Sesión</h1>
    <p>Accede a tu cuenta del <span class="system-name">Padrón de Proveedores</span></p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group">
            <label for="login-rfc">RFC*</label>
            <input type="text" id="login-rfc" name="rfc" 
                   value="{{ old('rfc') }}" 
                   placeholder="Ingresa tu RFC" 
                   required autofocus>
            @error('rfc')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label for="login-password">Contraseña*</label>
            <input type="password" id="login-password" name="password" 
                   placeholder="••••••••" required>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        @error('login_error')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        <button type="submit" class="btn" id="loginBtn">Iniciar Sesión</button>

        <div class="link-text">
            <button type="button" class="link-button" id="forgotPasswordBtn">Olvidé mi contraseña</button>
            <br>
            ¿No tienes una cuenta? <button type="button" class="link-button"
                id="goToRegisterFromLoginBtn">Regístrate</button>
        </div>
    </form>
</div>