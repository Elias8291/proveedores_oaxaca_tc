@extends('layouts.app')

@section('content')
<div class="container">
    <div class="left-section">
        <div class="carousel-wrapper">
            <div class="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/images/welcome/Dennis-Animada.png') }}" alt="Imagen 1">
                        <div class="carousel-text">
                            <h2>Inscripción Simplificada</h2>
                            <p>Regístrate en minutos y comienza a participar en licitaciones públicas de manera ágil y segura.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/images/welcome/sat-dennis.png') }}" alt="Imagen 2">
                        <div class="carousel-text">
                            <h2>Renovación sin Complicaciones</h2>
                            <p>Mantén tus datos actualizados fácilmente y renueva tu registro cuando lo necesites.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/images/welcome/dennis_check.png') }}" alt="Imagen 3">
                        <div class="carousel-text">
                            <h2>Validación de Documentos</h2>
                            <p>Nuestros operadores verifica tus documentos rápidamente para que puedas comenzar a operar.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/images/welcome/proveedor_casa.png') }}" alt="Imagen 4">
                        <div class="carousel-text">
                            <h2>Seguimiento en Tiempo Real</h2>
                            <p>Consulta el estado de tu registro, documentos y procesos desde cualquier lugar.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control prev" onclick="moveSlide(-1)">❮</button>
                <button class="carousel-control next" onclick="moveSlide(1)">❯</button>
                <div class="carousel-dots">
                    <span class="carousel-dot active" onclick="goToSlide(0)"></span>
                    <span class="carousel-dot" onclick="goToSlide(1)"></span>
                    <span class="carousel-dot" onclick="goToSlide(2)"></span>
                    <span class="carousel-dot" onclick="goToSlide(3)"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="right-section">
        <div class="forms-container">
            <div class="form-page welcome-form" id="welcomeForm">
                <img src="{{ asset('assets/images/welcome/administration-secretariat-logo.png') }}" alt="Logo" class="logo-img">
                <h1 class="welcome-title-animation">Bienvenido</h1>
                <p class="welcome-subtitle">Padrón de Proveedores de Oaxaca</p>
                <p class="welcome-description">Portal oficial para el registro y administración de proveedores del
                    Estado de Oaxaca. Accede a licitaciones y mantén actualizada tu información.</p>
                <div class="welcome-buttons">
                    <button type="button" class="btn" id="goToLoginBtn">Iniciar Sesión</button>
                    <button type="button" class="btn btn-secondary" id="goToRegisterBtn">Registrarse</button>
                </div>
            </div>

            @include('auth.login')
            @include('auth.forgot-password')
            @include('auth.register')
        </div>
    </div>

</div>

<div class="modal" id="registrationModal" style="display: none;" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-content">
        <span class="modal-close" id="modalCloseBtn" aria-label="Cerrar">×</span>
        <h2 id="modalTitle"></h2>
        <p id="modalMessage">Ups, algo salió mal. Inténtalo de nuevo.</p>
        <button class="btn" id="modalOkBtn">Aceptar</button>
    </div>
</div>
@endsection