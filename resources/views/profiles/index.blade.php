@extends('dashboard')

@section('title', '¡Bienvenidos a Proveedores de Oaxaca!')

<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">

@section('content')
<div class="dashboard-container">
    <div class="profile-header">
        <div class="profile-info">
            <div id="profileCircle" class="profile-circle">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="user-details">
                <h1 class="profile-name">{{ auth()->user()->name }}</h1>
                <p class="profile-description">
                    <span class="user-role">Proveedor registrado en Oaxaca</span>
                    <span class="user-status">{{ auth()->user()->email }}</span>
                </p>
                <div class="user-mini-data">
                    <span class="mini-data">ID: {{ auth()->user()->id }}</span>
                    <span class="mini-data">RFC: {{ auth()->user()->rfc }}</span>
                    <span class="mini-data">Estado: {{ ucfirst(auth()->user()->status) }}</span>
                </div>
            </div>
        </div>
       
    </div>

    <div class="tabs-container">
        <div class="tabs-navigation">
            <button class="tab-button active">Mi Cuenta</button>
            <button class="tab-button">Otros Usuarios</button>
            <button class="tab-button highlight">Estado de Cuenta</button>
            <button class="tab-button">Mis Registros</button>
            <button class="tab-button">Administrar Perfil</button>
        </div>
    </div>

    <div class="rewards-section">
        <div class="section-header">
            <h2>Actividad de Proveedor</h2>
            <div class="progress-label">
                <span>2023 Progreso</span>
                <span class="info-icon">i</span>
            </div>
        </div>

        <div class="content-grid">
            <div class="main-content">
                <div class="status-card">
                   
                </div>
            </div>
            <div class="stats-sidebar">
                <div class="stats-category">
                   
                </div>
                
                <div class="stats-category">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dividimos el alfabeto en 4 partes (A-Z tiene 26 letras)
        const alphabetGroups = {
            group1: ['A', 'B', 'C', 'D', 'E', 'F'], // 6 letras
            group2: ['G', 'H', 'I', 'J', 'K', 'L'], // 6 letras
            group3: ['M', 'N', 'O', 'P', 'Q', 'R'], // 6 letras
            group4: ['S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'] // 8 letras
        };
    
        // Colores para cada grupo y sus primeras letras
        const colors = {
            group1: { base: '#4285F4', first: '#EA4335' }, // Azul y rojo
            group2: { base: '#34A853', first: '#FBBC05' }, // Verde y amarillo
            group3: { base: '#AB47BC', first: '#FF6D01' }, // Púrpura y naranja
            group4: { base: '#1E88E5', first: '#00ACC1' }  // Azul oscuro y turquesa
        };
    
        const profileCircle = document.getElementById('profileCircle');
        if (profileCircle) {
            // Obtener las primeras dos letras del nombre del usuario
            const initials = profileCircle.textContent.trim();
            const firstLetter = initials.charAt(0).toUpperCase();
    
            // Determinar a qué grupo pertenece la primera letra
            let selectedColor;
            if (alphabetGroups.group1.includes(firstLetter)) {
                selectedColor = (firstLetter === 'A') ? colors.group1.first : colors.group1.base;
            } else if (alphabetGroups.group2.includes(firstLetter)) {
                selectedColor = (firstLetter === 'G') ? colors.group2.first : colors.group2.base;
            } else if (alphabetGroups.group3.includes(firstLetter)) {
                selectedColor = (firstLetter === 'M') ? colors.group3.first : colors.group3.base;
            } else if (alphabetGroups.group4.includes(firstLetter)) {
                selectedColor = (firstLetter === 'S') ? colors.group4.first : colors.group4.base;
            }
    
            profileCircle.style.backgroundColor = selectedColor;
        }
    });
</script>
@endsection