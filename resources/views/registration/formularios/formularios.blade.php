<!-- resources/views/registration/forms/formularios.blade.php -->
@extends('dashboard')

@section('title', 'Inscripción al Padrón de Proveedores - Proveedores de Oaxaca')
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">
<script src="{{ asset('assets/js/formulario_validaciones.js') }}"></script>

@section('content')
    <div class="form-background-container">
        <div class="inner-form-container">
            <div class="progress-container">
                <div class="progress-info">
                    <span class="progress-percent" id="progress-percent">0%</span>
                    <span class="progress-text">Completado</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
            </div>
            <div class="progress-tracker" id="progressTracker">
                @php
                    $tipoPersona = Auth::user()->solicitante->tipo_persona;
                    $secciones = $tipoPersona === 'Física' ? [1, 2, 6, 7] : [1, 2, 3, 4, 5, 6, 7];
                    $titulosSecciones = [
                        1 => 'Datos Generales',
                        2 => 'Domicilio',
                        3 => 'Datos de Constitución',
                        4 => 'Accionistas',
                        5 => 'Apoderado Legal',
                        6 => 'Documentos',
                        7 => 'Final'
                    ];
                @endphp
                @foreach ($secciones as $index => $seccion)
                    <div class="seccion" data-seccion="{{ $index + 1 }}">
                        <div class="seccion-numero">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="seccion-titulo">{{ $titulosSecciones[$seccion] }}</div>
                    </div>
                @endforeach
            </div>
            @if (in_array(1, $secciones)) <div id="seccion1" class="form-seccion" style="display: block;">@include('registration.formularios.seccion1')</div> @endif
            @if (in_array(2, $secciones)) <div id="seccion2" class="form-seccion" style="display: none;">@include('registration.formularios.seccion2')</div> @endif
            @if (in_array(3, $secciones)) <div id="seccion3" class="form-seccion" style="display: none;">@include('registration.formularios.seccion3')</div> @endif
            @if (in_array(4, $secciones)) <div id="seccion4" class="form-seccion" style="display: none;">@include('registration.formularios.seccion4')</div> @endif
            @if (in_array(5, $secciones)) <div id="seccion5" class="form-seccion" style="display: none;">@include('registration.formularios.seccion5')</div> @endif
            @if (in_array(6, $secciones)) <div id="seccion6" class="form-seccion" style="display: none;">@include('registration.formularios.seccion6')</div> @endif
            @if (in_array(7, $secciones)) <div id="seccion7" class="form-seccion" style="display: none;">@include('registration.formularios.seccion7')</div> @endif
            <div class="navigation-buttons">
                <button id="btnAnterior" style="display: none;">Anterior</button>
                <button id="btnSiguiente">Siguiente</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const progressTracker = document.getElementById('progressTracker');
        const secciones = progressTracker.getElementsByClassName('seccion');
        const progressFill = document.getElementById('progress-fill');
        const progressPercent = document.getElementById('progress-percent');
        let seccionActual = 1;
        const totalSecciones = secciones.length;
        const seccionMapping = @json($secciones);

        function actualizarProgreso() {
            for (let i = 0; i < secciones.length; i++) {
                const seccionNum = parseInt(secciones[i].getAttribute('data-seccion'));
                secciones[i].classList.remove('completed', 'active');
                if (seccionNum < seccionActual) {
                    secciones[i].classList.add('completed');
                } else if (seccionNum === seccionActual) {
                    secciones[i].classList.add('active');
                }
            }
            const porcentaje = ((seccionActual - 1) / (totalSecciones - 1)) * 100;
            progressFill.style.width = porcentaje + '%';
            progressPercent.textContent = Math.round(porcentaje) + '%';
            for (let i = 1; i <= 7; i++) {
                const seccionElement = document.getElementById(`seccion${i}`);
                if (seccionElement) {
                    seccionElement.style.display = (seccionMapping[seccionActual - 1] === i) ? 'block' : 'none';
                }
            }
            document.getElementById('btnAnterior').style.display = seccionActual === 1 ? 'none' : 'block';
            document.getElementById('btnSiguiente').textContent = seccionActual === totalSecciones ? 'Finalizar' : 'Siguiente';
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function siguienteSeccion() {
            if (seccionActual < totalSecciones) {
                seccionActual++;
                actualizarProgreso();
                scrollToTop();
            } else {
                alert('Formulario completado');
            }
        }

        function seccionAnterior() {
            if (seccionActual > 1) {
                seccionActual--;
                actualizarProgreso();
                scrollToTop();
            }
        }

        document.getElementById('btnSiguiente').addEventListener('click', siguienteSeccion);
        document.getElementById('btnAnterior').addEventListener('click', seccionAnterior);

        for (let i = 0; i < secciones.length; i++) {
            secciones[i].addEventListener('click', function() {
                const seccionNum = parseInt(this.getAttribute('data-seccion'));
                if (seccionNum <= seccionActual) {
                    seccionActual = seccionNum;
                    actualizarProgreso();
                    scrollToTop();
                }
            });
        }

        actualizarProgreso();
    });
    </script>
@endsection