@extends('dashboard')

@section('title', 'Inscripción al Padrón de Proveedores - Proveedores de Oaxaca')
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">

@section('content')
    <div class="form-background-container">
        <div class="inner-form-container">
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-info">
                    <span class="progress-percent" id="progress-percent">0%</span>
                    <span class="progress-text">Completado</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
            </div>

            <!-- Progress Tracker -->
            <div class="progress-tracker" id="progressTracker">
                @php
                    $tipoPersona = Auth::user()->solicitante->tipo_persona;
                    $steps = $tipoPersona === 'Física' ? [1, 2, 6, 7] : [1, 2, 3, 4, 5, 6, 7];
                    $stepTitles = [
                        1 => 'Información',
                        2 => 'Datos básicos',
                        3 => 'Reclamación',
                        4 => 'Detalles',
                        5 => 'Documentos',
                        6 => 'Revisión',
                        7 => 'Confirmación'
                    ];
                @endphp
                @foreach ($steps as $index => $step)
                    <div class="step" data-step="{{ $index + 1 }}">
                        <div class="step-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="step-title">{{ $stepTitles[$step] }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Step 1: Full Form Content -->
           

            <!-- Placeholder Steps 2–7 -->
            @if (in_array(1, $steps)) <div id="step1" class="form-step" style="display: none;">@include('registration.forms.step1-information')</div> @endif
            @if (in_array(2, $steps)) <div id="step2" class="form-step" style="display: none;">@include('registration.forms.step2-information')</div> @endif
            @if (in_array(3, $steps)) <div id="step3" class="form-step" style="display: none;">@include('registration.forms.step3-information')</div> @endif
            @if (in_array(4, $steps)) <div id="step4" class="form-step" style="display: none;">@include('registration.forms.step4-information')</div> @endif
            @if (in_array(5, $steps)) <div id="step5" class="form-step" style="display: none;">@include('registration.forms.step5-information')</div> @endif
            @if (in_array(6, $steps)) <div id="step6" class="form-step" style="display: none;">@include('registration.forms.step6-information')</div> @endif
            @if (in_array(7, $steps)) <div id="step7" class="form-step" style="display: none;">@include('registration.forms.step7-information')</div> @endif

            <!-- Navigation Buttons -->
            <div class="navigation-buttons">
                <button id="prevStep" style="display: none;">Anterior</button>
                <button id="nextStep">Siguiente</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const progressTracker = document.getElementById('progressTracker');
        const steps = progressTracker.getElementsByClassName('step');
        const progressFill = document.getElementById('progress-fill');
        const progressPercent = document.getElementById('progress-percent');
        let currentStep = 1;
        const totalSteps = steps.length;
        const stepMapping = @json($steps);

        function updateProgress() {
            for (let i = 0; i < steps.length; i++) {
                const stepNum = parseInt(steps[i].getAttribute('data-step'));
                steps[i].classList.remove('completed', 'active');
                if (stepNum < currentStep) {
                    steps[i].classList.add('completed');
                } else if (stepNum === currentStep) {
                    steps[i].classList.add('active');
                }
            }

            const percentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressFill.style.width = percentage + '%';
            progressPercent.textContent = Math.round(percentage) + '%';

            for (let i = 1; i <= 7; i++) {
                const stepElement = document.getElementById(`step${i}`);
                if (stepElement) {
                    stepElement.style.display = (stepMapping[currentStep - 1] === i) ? 'block' : 'none';
                }
            }

            document.getElementById('prevStep').style.display = currentStep === 1 ? 'none' : 'block';
            document.getElementById('nextStep').textContent = currentStep === totalSteps ? 'Finalizar' : 'Siguiente';
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                currentStep++;
                updateProgress();
                scrollToTop();
            } else {
                alert('Formulario completado');
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateProgress();
                scrollToTop();
            }
        }

        document.getElementById('nextStep').addEventListener('click', nextStep);
        document.getElementById('prevStep').addEventListener('click', prevStep);

        for (let i = 0; i < steps.length; i++) {
            steps[i].addEventListener('click', function() {
                const stepNum = parseInt(this.getAttribute('data-step'));
                if (stepNum <= currentStep) {
                    currentStep = stepNum;
                    updateProgress();
                    scrollToTop();
                }
            });
        }

        // Load solicitante data
        function cargarDatosSolicitante() {
            $.ajax({
                url: '/api/solicitante-data',
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.form-loading-message').show();
                },
                success: function(data) {
                    if (data.tipo_persona) {
                        $('#tipo_proveedor_display').text(data.tipo_persona);
                        if (data.tipo_persona.toLowerCase() === 'física') {
                            $('#grupo_curp').show();
                        } else {
                            $('#grupo_curp').hide();
                        }
                    } else {
                        $('#tipo_proveedor_display').text('No disponible');
                    }

                    if (data.curp) {
                        $('#curp_display').text(data.curp);
                    } else {
                        $('#curp_display').text('No aplica');
                    }

                    if (data.rfc) {
                        $('#rfc_display').text(data.rfc);
                    } else {
                        $('#rfc_display').text('No disponible');
                    }

                    if (data.email) {
                        $('#contacto_correo').val(data.email);
                    }
                    if (data.razon_social) {
                        $('#contacto_nombre').val(data.razon_social);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar datos del solicitante:', error);
                    $('#tipo_proveedor_display').text('Error al cargar');
                    $('#curp_display').text('Error al cargar');
                    $('#rfc_display').text('Error al cargar');
                },
                complete: function() {
                    $('.form-loading-message').hide();
                }
            });
        }

        // Load sectors
        function cargarSectores() {
            $.ajax({
                url: '/api/sectores',
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#sector').prop('disabled', true);
                },
                success: function(data) {
                    $('#sector').empty().append('<option value="">Seleccione un sector</option>');
                    $.each(data, function(index, sector) {
                        $('#sector').append($('<option>', {
                            value: sector.id,
                            text: sector.nombre
                        }));
                    });
                    $('#sector').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar sectores:', error);
                    $('#sector').prop('disabled', false);
                }
            });
        }

        // Load activities
        function cargarActividades(sectorId) {
            $.ajax({
                url: '/api/sectores/' + sectorId + '/actividades',
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#actividad_comercial').prop('disabled', true).html(
                        '<option value="">Cargando actividades...</option>');
                },
                success: function(data) {
                    $('#actividad_comercial').empty().append(
                        '<option value="">Seleccione una actividad</option>');
                    $.each(data, function(index, actividad) {
                        $('#actividad_comercial').append($('<option>', {
                            value: actividad.id,
                            text: actividad.nombre
                        }));
                    });
                    $('#actividad_comercial').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar actividades:', error);
                    $('#actividad_comercial').prop('disabled', false).html(
                        '<option value="">Error al cargar actividades</option>');
                }
            });
        }

        // Add selected activity
        function agregarActividadSeleccionada(id, nombre) {
            if ($('#actividades_seleccionadas .empty-message').length) {
                $('#actividades_seleccionadas').empty();
            }
            $('#actividades_seleccionadas').append(
                `<div class="actividad-item" id="actividad_${id}"><span>${nombre}</span><button type="button" class="remove-actividad" data-id="${id}"><i class="fas fa-times"></i></button><input type="hidden" name="actividades[]" value="${id}"></div>`
            );
            actualizarActividadesInput();
        }

        // Update activities input
        function actualizarActividadesInput() {
            const actividades = [];
            $('input[name="actividades[]"]').each(function() {
                actividades.push($(this).val());
            });
            $('#actividades_comerciales_input').val(actividades.join(','));
        }

        // Event handlers
        cargarDatosSolicitante();
        cargarSectores();

        $('#sector').change(function() {
            const sectorId = $(this).val();
            $('#actividades_seleccionadas').empty().html(
                '<div class="empty-message">No hay actividades seleccionadas</div>');
            $('#actividades_comerciales_input').val('');
            if (sectorId) {
                cargarActividades(sectorId);
            } else {
                $('#actividad_comercial').prop('disabled', true).html(
                    '<option value="">Primero seleccione un sector</option>');
            }
        });

        $('#actividad_comercial').change(function() {
            const actividadId = $(this).val();
            const actividadNombre = $(this).find('option:selected').text();
            if (actividadId && !$('#actividad_' + actividadId).length) {
                agregarActividadSeleccionada(actividadId, actividadNombre);
                $(this).val('');
            }
        });

        $(document).on('click', '.remove-actividad', function() {
            $(this).parent().remove();
            actualizarActividadesInput();
            if ($('#actividades_seleccionadas').children().length === 0) {
                $('#actividades_seleccionadas').html(
                    '<div class="empty-message">No hay actividades seleccionadas</div>');
            }
        });

        updateProgress();
    });
    </script>
@endsection