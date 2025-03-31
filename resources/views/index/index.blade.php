@extends('dashboard') <!-- Asumiendo que el layout anterior está en resources/views/layouts/app.blade.php -->

@section('title', 'Inicio - Dashboard Gobierno')

@section('content')
<div class="content">
    <div class="dashboard-welcome">
        <h1>Bienvenido al Dashboard</h1>
        <p>Hola, Nombre del Usuario. Aquí puedes gestionar tus actividades y revisar información importante.</p>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Usuarios Activos</h3>
                <p class="stat-number">150</p>
            </div>
            <div class="stat-card">
                <h3>Tareas Pendientes</h3>
                <p class="stat-number">12</p>
            </div>
            <div class="stat-card">
                <h3>Notificaciones</h3>
                <p class="stat-number">5</p>
            </div>
        </div>
    </div>
</div>
@endsection
