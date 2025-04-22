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
                    <span class="user-role">
                        @if(auth()->user()->role === 'solicitante')
                            Datos del solicitante
                        @elseif(auth()->user()->role === 'proveedor')
                            Datos del proveedor
                        @elseif(auth()->user()->role === 'revisor_1')
                            Datos del trabajador
                        @endif
                    </span>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alphabetGroups = {
        group1: ['A', 'B', 'C', 'D', 'E', 'F'],
        group2: ['G', 'H', 'I', 'J', 'K', 'L'],
        group3: ['M', 'N', 'O', 'P', 'Q', 'R'],
        group4: ['S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
    };

    const colors = {
        group1: { base: '#546E7A', first: '#607D8B' },
        group2: { base: '#5D4037', first: '#6D4C41' },
        group3: { base: '#455A64', first: '#546E7A' },
        group4: { base: '#37474F', first: '#455A64' }
    };

    const profileCircle = document.getElementById('profileCircle');
    if (profileCircle) {
        const initials = profileCircle.textContent.trim();
        const firstLetter = initials.charAt(0).toUpperCase();

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
        profileCircle.style.backgroundImage = `linear-gradient(135deg, ${selectedColor} 0%, ${darkenColor(selectedColor, 15)} 100%)`;
    }

    function darkenColor(hex, percent) {
        let r = parseInt(hex.substring(1,3), 16);
        let g = parseInt(hex.substring(3,5), 16);
        let b = parseInt(hex.substring(5,7), 16);
        
        r = Math.floor(r * (100 - percent) / 100);
        g = Math.floor(g * (100 - percent) / 100);
        b = Math.floor(b * (100 - percent) / 100);
        
        r = r.toString(16).padStart(2, '0');
        g = g.toString(16).padStart(2, '0');
        b = b.toString(16).padStart(2, '0');
        
        return `#${r}${g}${b}`;
    }
});
</script>
@endsection