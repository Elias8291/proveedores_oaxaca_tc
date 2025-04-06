<aside class="sidebar" id="sidebar">
    <nav class="sidebar-menu">
        <div class="menu-item active">
            <a href="{{ route('dashboard') }}" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                <div class="menu-text">Dashboard</div>
            </a>
        </div>
        <div class="menu-item profile-sidebar">
            <a href="{{ route('profiles.index') }}" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <div class="menu-text">Perfil</div>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ route('users.index') }}" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div class="menu-text">Usuarios</div>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ route('roles.index') }}" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg></div>
                <div class="menu-text">Roles</div>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ route('registration.index') }}" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 14l2 2 4-4"/></svg></div>
                <div class="menu-text">Inscripción</div>
            </a>
        </div>
        <div class="menu-item">
            <a href="#" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></div>
                <div class="menu-text">Revisión</div>
            </a>
        </div>
        <div class="menu-item">
            <a href="#" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:8px">
                <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                <div class="menu-text">Transparencia</div>
            </a>
        </div>
        <div class="menu-item logout-sidebar">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="width:100%">
                @csrf
                <button type="submit" id="logout-button" style="background:none;border:none;padding:0;cursor:pointer;display:flex;align-items:center;width:100%;text-decoration:none;color:inherit;gap:8px">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
                    <div class="menu-text">Cerrar Sesión</div>
                </button>
            </form>
        </div>
    </nav>
</aside>