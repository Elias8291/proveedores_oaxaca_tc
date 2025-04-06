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
            <div>
                <h1 class="profile-name">{{ auth()->user()->name }}</h1>
                <p class="profile-website">{{ auth()->user()->email }}</p>
                <div class="user-mini-data">
                    <span class="mini-data">ID: {{ auth()->user()->id }}</span>
                    <span class="mini-data">RFC: {{ auth()->user()->rfc }}</span>
                    <span class="mini-data">Estado: {{ ucfirst(auth()->user()->status) }}</span>
                </div>
            </div>
        </div>
        <div class="action-buttons">
            <button class="action-button button-outline">
                <i class="fas fa-share"></i> Outreach
            </button>
        </div>
    </div>

    <div class="profile-main">
        <div class="profile-content">
            <ul class="nav-tabs">
                <li><a href="#" class="active">Company overview</a></li>
                <li><a href="#">User activity</a></li>
                <li><a href="#">People <span class="badge">3</span></a></li>
                <li><a href="#">Opportunity lists <span class="badge">14</span></a></li>
            </ul>

            <div class="company-details">
                <div class="detail-box">
                    <p class="detail-title">Fecha de creación</p>
                    <p class="detail-value">{{ auth()->user()->created_at->format('d-M-Y') }}</p>
                </div>
                <div class="detail-box">
                    <p class="detail-title">Última actualización</p>
                    <p class="detail-value">{{ auth()->user()->updated_at->format('d-M-Y') }}</p>
                </div>
                <div class="detail-box">
                    <p class="detail-title">Último acceso</p>
                    <p class="detail-value">{{ auth()->user()->ultimo_acceso ? auth()->user()->ultimo_acceso->format('d-M-Y') : 'N/A' }}</p>
                </div>
                <div class="detail-box">
                    <p class="detail-title">Email verificado</p>
                    <p class="detail-value">{{ auth()->user()->email_verified_at ? auth()->user()->email_verified_at->format('d-M-Y') : 'No' }}</p>
                </div>
                <div class="location-box">
                    <div class="location-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <p class="detail-value">Oaxaca, México</p>
                        <p class="detail-title">Proveedor registrado</p>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-box">
                    <p class="detail-title">Tipo de usuario</p>
                    <p class="detail-value">{{ auth()->user()->tipo_usuario ?? 'Standard' }}</p>
                </div>
                <div class="detail-box">
                    <p class="detail-title">Estado de cuenta</p>
                    <p class="detail-value">{{ ucfirst(auth()->user()->status) }}</p>
                </div>
            </div>

            <div class="company-description">
                <h3 class="section-title">Información adicional</h3>
                <p class="description-text">Usuario registrado en el sistema de proveedores de Oaxaca con acceso a todas las funcionalidades disponibles según su plan.</p>
                <div class="tags">
                    <span class="tag">Proveedor Oaxaca</span>
                    <span class="tag">{{ auth()->user()->rfc ? 'RFC Registrado' : 'Sin RFC' }}</span>
                </div>
            </div>

           
        </div>

        <div class="profile-sidebar">
            <div class="score-card">
                <div class="score-display">
                    <div class="score-circle">
                        <svg viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45"></circle>
                            <circle cx="50" cy="50" r="45" class="progress"></circle>
                        </svg>
                        <div class="score-number">{{ auth()->user()->status === 'active' ? '95' : '65' }}</div>
                    </div>
                </div>
                <p class="score-text">Estado <span>{{ ucfirst(auth()->user()->status) }}</span> y actividad <span>{{ auth()->user()->ultimo_acceso ? 'Reciente' : 'Inactiva' }}</span></p>
                
                <div class="metrics-list">
                    <div class="metric-item">
                        <span class="metric-label">Días registrado</span>
                        <span class="metric-value">{{ now()->diffInDays(auth()->user()->created_at) }}</span>
                        <div class="progress-bar">
                            <div class="progress-fill green" style="width: {{ min(100, now()->diffInDays(auth()->user()->created_at)/365*100) }}%;"></div>
                        </div>
                    </div>
                    <div class="metric-item">
                        <span class="data-label">Completitud perfil</span>
                        <span class="metric-value">{{ auth()->user()->rfc ? '85' : '45' }}</span>
                        <div class="progress-bar">
                            <div class="progress-fill {{ auth()->user()->rfc ? 'green' : '' }}" style="width: {{ auth()->user()->rfc ? '85' : '45' }}%;"></div>
                        </div>
                    </div>
                    <div class="metric-item">
                        <span class="metric-label">Verificación email</span>
                        <span class="metric-value">{{ auth()->user()->email_verified_at ? '100' : '30' }}</span>
                        <div class="progress-bar">
                            <div class="progress-fill {{ auth()->user()->email_verified_at ? 'green' : '' }}" style="width: {{ auth()->user()->email_verified_at ? '100' : '30' }}%;"></div>
                        </div>
                    </div>
                    <div class="metric-item">
                        <span class="metric-label">Actividad reciente</span>
                        <span class="metric-value">{{ auth()->user()->ultimo_acceso ? now()->diffInDays(auth()->user()->ultimo_acceso) < 7 ? '80' : '50' : '10' }}</span>
                        <div class="progress-bar">
                            <div class="progress-fill {{ auth()->user()->ultimo_acceso && now()->diffInDays(auth()->user()->ultimo_acceso) < 7 ? 'green' : '' }}" style="width: {{ auth()->user()->ultimo_acceso ? now()->diffInDays(auth()->user()->ultimo_acceso) < 7 ? '80' : '50' : '10' }}%;"></div>
                        </div>
                    </div>
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