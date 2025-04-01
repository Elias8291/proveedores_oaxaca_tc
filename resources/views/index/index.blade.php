@extends('dashboard')

@section('title', '¡Bienvenidos a Proveedores de Oaxaca!')

@section('content')
<div class="container">
    <!-- Encabezado de Bienvenida -->
    <div class="welcome-header">
        <h1>¡Bienvenidos a Proveedores de Oaxaca, {{ auth()->user()->name }}! <span class="emoji"></span></h1>
        <p>Conecta con proveedores locales de Oaxaca y automatiza tus procesos para impulsar tu negocio.</p>
    </div>
    
    <div class="divider"></div>
        
    <h2 class="section-title">Descubre cómo usar Proveedores de Oaxaca</h2>
    <div class="cards-container">
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
    
    <h2 class="section-title">Obtén ayuda</h2>
    <div class="cards-container">
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
@endsection