@extends('dashboard')

@section('title', '¡Bienvenidos a Proveedores de Oaxaca!')
<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">


@section('content')
<div class="container">
    <!-- Sección para mostrar los usuarios -->
    <h2 class="section-title">Lista de Usuarios Registrados</h2>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <div class="checkbox-container">
                            <input type="checkbox" class="form-checkbox">
                        </div>
                    </th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="checkbox-container">
                                <input type="checkbox" class="form-checkbox">
                            </div>
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->rfc }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="status-indicator status-active">
                                Activo
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-info">Editar</a>
                            <a href="#" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection