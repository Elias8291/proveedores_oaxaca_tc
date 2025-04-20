@extends('dashboard')

@section('title', '¡Bienvenidos a Proveedores de Oaxaca!')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="dashboard-container">
    <div class="content-wrapper">
        <!-- Header Section with Title -->
        <h1 class="page-title">Administración de Usuarios</h1>
        <p class="page-subtitle">Gestiona todos los usuarios registrados en la plataforma de Proveedores de Oaxaca</p>
        
        <!-- Controls Bar with Search and Buttons -->
        <div class="controls-bar">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Buscar usuarios por nombre, RFC o email...">
            </div>
            
            <div class="button-group">
                <button class="btn-secondary">
                    <i class="fas fa-filter btn-icon"></i>
                    Filtrar
                </button>
                <button class="btn-primary" id="openUserModalBtn">
                    <i class="fas fa-plus btn-icon"></i>
                    Agregar Usuario
                </button>
            </div>
        </div>
        
        <!-- Table Container -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RFC</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="product-name-cell">
                                <div>
                                    <div class="product-name">{{ $user->name }}</div>
                                    <div class="product-id">Desde {{ $user->created_at->format('d M Y') }}</div>
                                </div>
                            </td>
                            <td>
                                <span>{{ $user->rfc }}</span>
                                <div class="product-id">#{{ substr($user->rfc, 0, 8) }}</div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="role-badge">{{ $role->name }}</span>
                                        @if(!$loop->last), @endif
                                    @endforeach
                                @else
                                    <span class="role-badge no-role">Sin rol</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusDisplay = [
                                        'active' => 'Activo',
                                        'inactive' => 'Inactivo',
                                        'suspended' => 'Suspendido'
                                    ];
                                    $statusText = $statusDisplay[$user->status] ?? 'Desconocido';
                                @endphp
                                <div class="status-indicator status-{{ $user->status }}">
                                    {{ $statusText }}
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <div class="page-item disabled">
                <a class="page-link">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </div>
            <div class="page-item active">
                <a class="page-link">1</a>
            </div>
            <div class="page-item">
                <a class="page-link">2</a>
            </div>
            <div class="page-item">
                <a class="page-link">3</a
            </div>
            <div class="page-item">
                <a class="page-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal-overlay" id="createUserModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Crear Nuevo Usuario</h3>
                <button class="modal-close-btn">×</button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                    @csrf <!-- Add CSRF token -->
                    <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" id="name" name="name" placeholder="Ej. Juan Pérez López">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="rfc">RFC</label>
                            <input type="text" id="rfc" name="rfc" placeholder="Ej. PELJ920312HDF">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Ej. ejemplo@correo.com">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Rol del Usuario</label>
                        <select id="role" name="role">
                            <option value="">Seleccionar rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Estado</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="status" value="active" checked>
                                <span class="radio-checkmark"></span>
                                Activo
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="status" value="inactive">
                                <span class="radio-checkmark"></span>
                                Inactivo
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary modal-cancel-btn">Cancelar</button>
                <button class="btn-primary modal-confirm-btn">Crear Usuario</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-overlay.active {
    display: flex;
}

.modal-container {
    background-color: #fff;
    border-radius: 8px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e9e9e9;
}

.modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.modal-close-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #999;
}

.modal-body {
    padding: 20px;
    max-height: 70vh;
    overflow-y: auto;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    padding: 15px 20px;
    border-top: 1px solid #e9e9e9;
    gap: 12px;
}

/* Form Styles */
.form-group {
    margin-bottom: 16px;
}

.form-row {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
}

.form-row .form-group {
    flex: 1;
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #4a6cf7;
    outline: none;
    box-shadow: 0 0 0 2px rgba(74, 108, 247, 0.2);
}

/* Radio buttons */
.radio-group {
    display: flex;
    gap: 16px;
}

.radio-option {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.radio-option input[type="radio"] {
    width: auto;
    margin-right: 8px;
}

/* Button styles */
.btn-primary {
    background-color: #4a6cf7;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
}

.btn-secondary {
    background-color: #f5f5f5;
    color: #333;
    border: 1px solid #ddd;
    padding: 10px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #3a5ce5;
}

.btn-secondary:hover {
    background-color: #e9e9e9;
}
</style>

<script>
// Wait for the DOM to be fully loaded
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get references to elements
    const addUserBtn = document.getElementById('openUserModalBtn');
    const modalOverlay = document.getElementById('createUserModal');
    const modalCloseBtn = modalOverlay.querySelector('.modal-close-btn');
    const modalCancelBtn = modalOverlay.querySelector('.modal-cancel-btn');
    const modalConfirmBtn = modalOverlay.querySelector('.modal-confirm-btn');
    const userForm = document.getElementById('createUserForm');
    
    // Function to open the modal
    function openModal() {
        modalOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    }
    
    // Function to close the modal
    function closeModal() {
        modalOverlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
        userForm.reset(); // Reset form fields
    }
    
    // Add event listeners for opening and closing the modal
    addUserBtn.addEventListener('click', openModal);
    modalCloseBtn.addEventListener('click', closeModal);
    modalCancelBtn.addEventListener('click', closeModal);
    
    // Handle form submission
    modalConfirmBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(userForm);
        const userData = {
            name: formData.get('name'),
            rfc: formData.get('rfc'),
            email: formData.get('email'),
            password: formData.get('password'),
            password_confirmation: formData.get('password_confirmation'),
            role: formData.get('role'),
            status: formData.get('status'),
            _token: formData.get('_token') // Include CSRF token
        };
        
        // Basic client-side validation
        if (!userData.name || !userData.rfc || !userData.email || !userData.password || !userData.role) {
            alert('Por favor completa todos los campos obligatorios');
            return;
        }
        
        if (userData.password !== userData.password_confirmation) {
            alert('Las contraseñas no coinciden');
            return;
        }
        
        // Send data using fetch API
        fetch('{{ route('users.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': userData._token
            },
            body: JSON.stringify(userData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al crear usuario');
            }
            return response.json();
        })
        .then(data => {
            // Show success message
            alert('Usuario creado exitosamente');
            userForm.reset(); // Reset form fields after successful submission
            // Modal stays open; user must explicitly close it
        })
        .catch(error => {
            alert('Error: ' + error.message);
            // Modal stays open; user must explicitly close it
        });
    });
});
</script>
@endsection