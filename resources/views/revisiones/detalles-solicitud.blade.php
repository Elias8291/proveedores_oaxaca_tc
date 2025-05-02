@extends('dashboard')

@section('title', 'Detalles de Solicitud')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="dashboard-container">
    <div class="content-wrapper">
        <h1 class="page-title">Detalles de Solicitud</h1>
        <p class="page-subtitle">Revisa los detalles de la solicitud</p>

        <!-- Mostrar mensaje de error si existe -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Detalles del solicitante -->
        <div class="details-container">
            @include('registration.formularios.seccion1')
        </div>
    </div>
</div>
@endsection