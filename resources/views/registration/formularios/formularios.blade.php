@extends('dashboard')

@section('title', 'Inscripción al Padrón de Proveedores - Proveedores de Oaxaca')
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">
<script src="{{ asset('assets/js/formulario_validaciones.js') }}"></script>

@section('content')
    <div class="form-background-container">
        <div class="inner-form-container">
            <div class="progress-container">
                <div class="progress-info">
                    <div class="progress-status">
                        <span class="progress-percent" id="progress-percent">0%</span>
                        <span class="progress-text">Completado</span>
                    </div>
                    <span class="progress-text persona-type-text">
                        Formulario para el tipo de persona:
                        @if (Auth::user()->hasRole('revisor_1'))
                            <span class="persona-type-value" id="persona-type-value">Pendiente</span>
                        @else
                            <span
                                class="persona-type-value">{{ Auth::user()->solicitante->tipo_persona ?? 'No definido' }}</span>
                        @endif
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
            </div>
            <div class="progress-tracker" id="progressTracker">
                @php
                    $user = Auth::user();
                    $isRevisor = $user->hasRole('revisor_1');
                    // Initialize sections: For revisor_1, only section 1 initially
                    $tipoPersona = $isRevisor ? null : $user->solicitante->tipo_persona ?? null;
                    $secciones = $isRevisor ? [1] : ($tipoPersona === 'Física' ? [1, 2, 6, 7] : [1, 2, 3, 4, 5, 6, 7]);
                    $titulosSecciones = [
                        1 => 'Datos Generales',
                        2 => 'Domicilio',
                        3 => 'Datos de Constitución',
                        4 => 'Accionistas',
                        5 => 'Apoderado Legal',
                        6 => 'Documentos',
                        7 => 'Final',
                    ];
                @endphp
                @foreach ($secciones as $index => $seccion)
                    <div class="seccion" data-seccion="{{ $index + 1 }}">
                        <div class="seccion-numero">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="seccion-titulo">{{ $titulosSecciones[$seccion] }}</div>
                    </div>
                @endforeach
            </div>
            <!-- Render all possible sections, but control visibility with JS -->
            @foreach ([1, 2, 3, 4, 5, 6, 7] as $seccion)
                <div id="seccion{{ $seccion }}" class="form-seccion"
                    style="display: {{ $seccion === 1 ? 'block' : 'none' }};">
                    <form id="formulario{{ $seccion }}">
                        @include("registration.formularios.seccion{$seccion}")
                    </form>
                </div>
            @endforeach
            <div class="navigation-buttons">
                <button type="button" id="btnAnterior" style="display: none;">Anterior</button>
                <button type="submit" id="btnSiguiente" form="formulario1" disabled>Siguiente</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressTracker = document.getElementById('progressTracker');
            const progressFill = document.getElementById('progress-fill');
            const progressPercent = document.getElementById('progress-percent');
            const personaTypeValue = document.getElementById('persona-type-value');
            const tipoPersonaSelect = document.getElementById('tipo_persona');
            const btnSiguiente = document.getElementById('btnSiguiente');
            const btnAnterior = document.getElementById('btnAnterior');
            const isRevisor = @json($isRevisor);
            let seccionActual = 1;
            let secciones = @json($secciones);
            let totalSecciones = secciones.length;
            let tipoPersona = isRevisor ? null : @json($tipoPersona);
            let isNavigating = false;

            const seccionesFisica = [1, 2, 6, 7];
            const seccionesMoral = [1, 2, 3, 4, 5, 6, 7];
            const titulosSecciones = @json($titulosSecciones);

            function updateProgressTracker() {
                progressTracker.innerHTML = '';
                secciones.forEach((seccion, index) => {
                    const div = document.createElement('div');
                    div.classList.add('seccion');
                    div.setAttribute('data-seccion', index + 1);
                    div.innerHTML = `
                <div class="seccion-numero">${String(index + 1).padStart(2, '0')}</div>
                <div class="seccion-titulo">${titulosSecciones[seccion]}</div>
            `;
                    if (index + 1 < seccionActual) {
                        div.classList.add('completed');
                    } else if (index + 1 === seccionActual) {
                        div.classList.add('active');
                    }
                    progressTracker.appendChild(div);
                    div.addEventListener('click', function() {
                        const seccionNum = parseInt(this.getAttribute('data-seccion'));
                        if (seccionNum <= seccionActual) {
                            seccionActual = seccionNum;
                            actualizarProgreso();
                            scrollToTop();
                        }
                    });
                });
            }

            function actualizarProgreso() {
                totalSecciones = secciones.length;
                const porcentaje = totalSecciones === 1 ? 0 : ((seccionActual - 1) / (totalSecciones - 1)) * 100;
                progressFill.style.width = porcentaje + '%';
                progressPercent.textContent = Math.round(porcentaje) + '%';

                for (let i = 1; i <= 7; i++) {
                    const seccionElement = document.getElementById(`seccion${i}`);
                    if (seccionElement) {
                        seccionElement.style.display = (secciones[seccionActual - 1] === i) ? 'block' : 'none';
                    }
                }

                btnAnterior.style.display = seccionActual === 1 ? 'none' : 'block';
                btnSiguiente.textContent = seccionActual === totalSecciones ? 'Finalizar' : 'Siguiente';
                btnSiguiente.setAttribute('form', `formulario${secciones[seccionActual - 1]}`);
                btnSiguiente.disabled = isRevisor && !tipoPersona;

                updateProgressTracker();
            }

            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function updateSectionsByTipoPersona(tipo) {
                tipoPersona = tipo;
                secciones = tipo === 'Física' ? seccionesFisica : seccionesMoral;
                totalSecciones = secciones.length;
                personaTypeValue.textContent = tipo;
                // Solo reiniciar seccionActual si estamos en una sección no válida
                if (!secciones.includes(secciones[seccionActual - 1])) {
                    seccionActual = 1;
                }
                updateProgressTracker();
                actualizarProgreso();
                btnSiguiente.disabled = false;
            }

            if (isRevisor && tipoPersonaSelect) {
                tipoPersonaSelect.addEventListener('change', function() {
                    const selectedTipo = this.value;
                    if (selectedTipo === 'Física' || selectedTipo === 'Moral') {
                        updateSectionsByTipoPersona(selectedTipo);
                    } else {
                        personaTypeValue.textContent = 'Pendiente';
                        secciones = [1];
                        totalSecciones = 1;
                        seccionActual = 1;
                        updateProgressTracker();
                        actualizarProgreso();
                        btnSiguiente.disabled = true;
                    }
                });
            }

            window.formNavigation = {
                goToNextSection: function() {
                    if (seccionActual < totalSecciones) {
                        seccionActual++;
                        actualizarProgreso();
                        scrollToTop();
                    } else {
                        const form = document.getElementById(`formulario${secciones[seccionActual - 1]}`);
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
                    return secciones[seccionActual - 1];
                },
                updateSectionsByTipoPersona: updateSectionsByTipoPersona
            };

            btnSiguiente.addEventListener('click', function(e) {
                e.preventDefault();
                if (isNavigating) return;
                isNavigating = true;

                const currentForm = document.getElementById(`formulario${secciones[seccionActual - 1]}`);
                const inputs = currentForm.querySelectorAll('input, select, textarea');
                let isValid = true;

                inputs.forEach(input => {
                    if (input.type !== 'hidden' && input.name !== 'actividad') {
                        input.dispatchEvent(new Event('change'));
                        input.dispatchEvent(new Event('blur'));
                        // Validar que los campos requeridos estén llenos
                        if (input.hasAttribute('required') && !input.value.trim()) {
                            isValid = false;
                            input.classList.add('error'); // Agregar clase de error si es necesario
                        } else {
                            input.classList.remove('error');
                        }
                    }
                });

                if (isValid) {
                    window.formNavigation.goToNextSection();
                } else {
                    console.log('Formulario no válido, revisa los campos requeridos.');
                }

                setTimeout(() => {
                    isNavigating = false;
                }, 500);
            });

            btnAnterior.addEventListener('click', function() {
                window.formNavigation.goToPreviousSection();
            });

            updateProgressTracker();
            actualizarProgreso();
        });
    </script>
@endsection
