@extends('dashboard')

@section('title', '¡Bienvenidos a Proveedores de Oaxaca!')

@section('content')
<!-- Contenedor principal con fondo suave -->
<div class="dashboard-container">
    <!-- Tarjeta de bienvenida con hora -->
    <div class="welcome-card">
        <div class="welcome-left">
            <div class="welcome-status">Sesión Activa</div>
            <h2 id="greeting">Buenos días, {{ auth()->user()->name }}</h2>
            <p class="welcome-subtitle">¿Cómo va tu día? 🌟</p>
            <div class="time-display" id="currentTime">10:29 am</div>
        </div>
        <div class="welcome-right">
            <!-- Corregimos la ruta de la imagen para asegurarnos que se cargue correctamente -->
            <img src="{{ asset('assets/images/welcome/jacqueAI.png') }}" alt="Asistente" class="welcome-image">
        </div>
    </div>
    <!-- Secciones lado a lado para Features y Help -->
    <div class="side-by-side-sections">
        <!-- Features Section -->
        <div class="side-section features-section">
            <h2 class="section-title">Descubre cómo usar Proveedores de Oaxaca</h2>
            <div class="cards-container-vertical">
                <!-- Tarjeta: Subir Documentos -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-upload">
                            <i class="fas fa-upload"></i>
                        </div>
                        <h3>Subir Documentos</h3>
                        <div class="card-meta">Carga contratos o catálogos de proveedores</div>
                    </div>
                </div>
                
                <!-- Tarjeta: Revisar Estado -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-status">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>Revisar Estado</h3>
                        <div class="card-meta">Consulta el estado de tus pedidos</div>
                    </div>
                </div>
                
                <!-- Tarjeta: Explorar Proveedores -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-suppliers">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <h3>Explorar Proveedores</h3>
                        <div class="card-meta">Encuentra proveedores locales de Oaxaca</div>
                    </div>
                </div>
                
                <!-- Tarjeta: Automatizar Tareas -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-automate">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3>Automatizar Tareas</h3>
                        <div class="card-meta">Simplifica la gestión de tus compras</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Help Section -->
        <div class="side-section help-section">
            <h2 class="section-title">Obtén ayuda</h2>
            <div class="cards-container-vertical">
                <!-- Tarjeta: Documentación -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-docs">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3>Documentación</h3>
                        <div class="card-meta">Aprende en detalle</div>
                    </div>
                </div>
                
                <!-- Tarjeta: Incorporación -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-onboarding">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <h3>Incorporación</h3>
                        <div class="card-meta">Recorrido del producto</div>
                    </div>
                </div>
                
                <!-- Tarjeta: Foro de la Comunidad -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-community">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Foro de la Comunidad</h3>
                        <div class="card-meta">Conecta con otros usuarios</div>
                    </div>
                </div>
                
                <!-- Tarjeta: Tutoriales -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon icon-tutorials">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>Tutoriales</h3>
                        <div class="card-meta">Domina Proveedores de Oaxaca</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para la hora y saludo -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para actualizar la hora
        function updateTime() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const ampm = hours >= 12 ? 'pm' : 'am';
            const formattedHours = hours % 12 || 12;
            const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
            
            document.getElementById('currentTime').textContent = `${formattedHours}.${formattedMinutes} ${ampm}`;
            
            // Actualizar el saludo según la hora
            const greeting = document.getElementById('greeting');
            const userName = '{{ auth()->user()->name }}';
            
            if (hours >= 5 && hours < 12) {
                greeting.textContent = `Buenos días, ${userName}`;
            } else if (hours >= 12 && hours < 19) {
                greeting.textContent = `Buenas tardes, ${userName}`;
            } else {
                greeting.textContent = `Buenas noches, ${userName}`;
            }
        }
        
        // Actualizar la hora inmediatamente
        updateTime();
        
        // Actualizar la hora cada minuto
        setInterval(updateTime, 60000);
    });
</script>
@endsection