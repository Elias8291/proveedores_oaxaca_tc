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
            @if (in_array(1, $secciones))
                <div id="seccion1" class="form-seccion" style="display: block;">
                    <form id="formulario1">
                        @include('registration.formularios.seccion1')
                    </form>
                </div>
            @endif
            @if (in_array(2, $secciones))
                <div id="seccion2" class="form-seccion" style="display: none;">
                    <form id="formulario2">
                        @include('registration.formularios.seccion2')
                    </form>
                </div>
            @endif
            @if (in_array(3, $secciones))
                <div id="seccion3" class="form-seccion" style="display: none;">
                    <form id="formulario3">
                        @include('registration.formularios.seccion3')
                    </form>
                </div>
            @endif
            @if (in_array(4, $secciones))
                <div id="seccion4" class="form-seccion" style="display: none;">
                    <form id="formulario4">
                        @include('registration.formularios.seccion4')
                    </form>
                </div>
            @endif
            @if (in_array(5, $secciones))
                <div id="seccion5" class="form-seccion" style="display: none;">
                    <form id="formulario5">
                        @include('registration.formularios.seccion5')
                    </form>
                </div>
            @endif
            @if (in_array(6, $secciones))
                <div id="seccion6" class="form-seccion" style="display: none;">
                    <form id="formulario6">
                        @include('registration.formularios.seccion6')
                    </form>
                </div>
            @endif
            @if (in_array(7, $secciones))
                <div id="seccion7" class="form-seccion" style="display: none;">
                    <form id="formulario7">
                        @include('registration.formularios.seccion7')
                    </form>
                </div>
            @endif
            <div class="navigation-buttons">
                <button type="button" id="btnAnterior" style="display: none;">Anterior</button>
                <button type="submit" id="btnSiguiente" form="formulario1">Siguiente</button>
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
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnAnterior = document.getElementById('btnAnterior');

        window.formNavigation = {
            goToNextSection: function() {
                if (seccionActual < totalSecciones) {
                    seccionActual++;
                    actualizarProgreso();
                    scrollToTop();
                } else {
                    const form = document.getElementById(`formulario${seccionMapping[seccionActual - 1]}`);
                    form.submit();
                }
            },
            goToPreviousSection: function() {
                if (seccionActual > 1) {
                    seccionActual--;
                    actualizarProgreso();
                    scrollToTop();
                }
            },
            getCurrentSection: function() {
                return seccionMapping[seccionActual - 1];
            }
        };

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
            btnAnterior.style.display = seccionActual === 1 ? 'none' : 'block';
            btnSiguiente.textContent = seccionActual === totalSecciones ? 'Finalizar' : 'Siguiente';
            btnSiguiente.setAttribute('form', `formulario${seccionMapping[seccionActual - 1]}`);
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        btnSiguiente.addEventListener('click', function(e) {
            e.preventDefault();
            const currentForm = document.getElementById(`formulario${seccionMapping[seccionActual - 1]}`);
            const inputs = currentForm.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.type !== 'hidden' && input.name !== 'actividad') {
                    input.dispatchEvent(new Event('change'));
                    input.dispatchEvent(new Event('blur'));
                }
            });
            currentForm.dispatchEvent(new Event('submit')); // Trigger form submission
        });

        btnAnterior.addEventListener('click', function() {
            window.formNavigation.goToPreviousSection();
        });

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