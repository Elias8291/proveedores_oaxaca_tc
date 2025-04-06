@extends('dashboard')

@section('title', 'Administración de Roles - Proveedores de Oaxaca')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="dashboard-container">
    <div class="content-wrapper">
        <!-- Header Section with Title -->
        <h1 class="page-title">Administración de Roles</h1>
        <p class="page-subtitle">Gestiona todos los roles disponibles en la plataforma de Proveedores de Oaxaca</p>
        
        <!-- Controls Bar with Search and Buttons -->
        <div class="controls-bar">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Buscar roles por nombre o descripción...">
            </div>
            
            <div class="button-group">
                <button class="btn-secondary">
                    <i class="fas fa-filter btn-icon"></i>
                    Filtrar
                </button>
                <button class="btn-primary">
                    <i class="fas fa-plus btn-icon"></i>
                    Agregar Rol
                </button>
            </div>
        </div>
        
        <!-- Table Container -->
      <!-- Table Container -->
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Descripción</th>
                <th>Permisos</th>
                <th>Usuarios Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td class="product-name-cell">
                        <div>
                            <div class="product-name">{{ $role->name }}</div>
                            <div class="product-id">Creado {{ $role->created_at->format('d M Y') }}</div>
                        </div>
                    </td>
                    <td>{{ $role->description ?? 'Sin descripción' }}</td>
                    <td>
                        <div class="permissions-count">
                            {{ count($role->permissions) }} permisos
                            <button class="btn-action view-permissions">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ $role->users_count ?? 0 }} usuarios</td>
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
                <a class="page-link">3</a>
            </div>
            <div class="page-item">
                <a class="page-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection