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
                <button class="btn-primary">
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
                        <th>Tipo</th>
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
                                @php
                                    $types = ['Admin', 'Cliente', 'Proveedor', 'Empleado', 'Visitante'];
                                    $type = $types[$user->id % count($types)];
                                @endphp
                                {{ $type }}
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