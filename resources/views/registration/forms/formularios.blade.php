@extends('dashboard')

@section('title', 'Inscripción al Padrón de Proveedores - Proveedores de Oaxaca')
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">

@section('content')
<div class="dashboard-container">
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

    @if (in_array(1, $steps)) <div id="step1">@include('registration.forms.step1-information')</div> @endif
    @if (in_array(2, $steps)) <div id="step2">@include('registration.forms.step2-information')</div> @endif
    @if (in_array(3, $steps)) <div id="step3">@include('registration.forms.step3-information')</div> @endif
    @if (in_array(4, $steps)) <div id="step4">@include('registration.forms.step4-information')</div> @endif
    @if (in_array(5, $steps)) <div id="step5">@include('registration.forms.step5-information')</div> @endif
    @if (in_array(6, $steps)) <div id="step6">@include('registration.forms.step6-information')</div> @endif
    @if (in_array(7, $steps)) <div id="step7">@include('registration.forms.step7-information')</div> @endif

    <div class="navigation-buttons">
        <button id="prevStep" style="display: none;">Anterior</button>
        <button id="nextStep">Siguiente</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressTracker = document.getElementById('progressTracker');
    const steps = progressTracker.getElementsByClassName('step');
    const progressFill = document.getElementById('progress-fill');
    const progressPercent = document.getElementById('progress-percent');
    let currentStep = 1;
    const totalSteps = steps.length;
    const stepMapping = @json($steps); // Maps display step to actual form step (e.g., 3 -> 6 for Física)

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

    updateProgress();
});
</script>
@endsection