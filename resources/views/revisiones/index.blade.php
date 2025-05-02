@extends('dashboard')

@section('title', 'Revisión de Solicitudes')

<link rel="stylesheet" href="{{ asset('assets/css/tabla.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="dashboard-container">
    <div class="content-wrapper">
        <h1 class="page-title">Revisión de Solicitudes</h1>
        <p class="page-subtitle">Consulta los datos de solicitantes registrados en el sistema</p>

        <!-- Tabla de solicitantes -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RFC</th>
                        <th>Razón Social</th>
                        <th>Trámite</th>
                        <th>Acción</th> <!-- Nueva columna Acción -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan Pérez López</td>
                        <td>PELJ920312HDF</td>
                        <td>Comercializadora Oaxaca SA de CV</td>
                        <td>Inscripción</td>
                        <td>
                            <a href="/detalles-solicitud" class="btn-primary">Iniciar Revisión</a>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>María Gómez Ruiz</td>
                        <td>GORU850724HDF</td>
                        <td>Distribuciones del Sur</td>
                        <td>Renovación</td>
                        <td>
                            <a href="/detalles-solicitud" class="btn-primary">Iniciar Revisión</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Carlos Díaz Morales</td>
                        <td>DIMC780502HDF</td>
                        <td>Servicios y Mantenimientos Integrales</td>
                        <td>Actualización</td>
                        <td>
                            <a href="/detalles-solicitud" class="btn-primary">Iniciar Revisión</a>

                        </td>
                    </tr>
                    <tr>
                        <td>Laura Méndez Torres</td>
                        <td>METL901015HDF</td>
                        <td>Constructora LMT</td>
                        <td>Inscripción</td>
                        <td>
                            <a href="#" class="btn-primary">Iniciar Revisión</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
