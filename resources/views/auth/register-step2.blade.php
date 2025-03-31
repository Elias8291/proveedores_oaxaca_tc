@extends('layouts.app')

@section('content')
<div class="form-page register-form" id="registerFormStep2">
    <button class="back-btn" id="backFromRegisterStep2Btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        Atrás
    </button>

    <img src="{{ asset('assets/images/welcome/administration-secretariat-logo.png') }}" alt="Logo" class="logo-img">
    <h1>Datos del PDF</h1>
    <p>Revisa la información extraída</p>

    <div id="pdf-data-preview">
        <!-- Aquí se inyectará el contenido dinámico desde JavaScript -->
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        <input type="hidden" name="name" id="form-name">
        <input type="hidden" name="rfc" id="form-rfc">
        <input type="hidden" name="sat_file_date" id="form-date">
        <input type="hidden" name="regimen" id="form-regimen">
        <input type="hidden" name="qr_url" id="form-qr-url">
        <button type="submit" class="btn" id="registerBtn">Registrarse</button>
    </form>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/components/pdf-processor.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/pdf-processor.js') }}"></script>
@endpush