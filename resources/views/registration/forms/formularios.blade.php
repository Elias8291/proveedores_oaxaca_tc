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
        <div class="step" data-step="1">
            <div class="step-number">01</div>
            <div class="step-title">Información</div>
        </div>
        <div class="step" data-step="2">
            <div class="step-number">02</div>
            <div class="step-title">Datos básicos</div>
        </div>
        <div class="step" data-step="3">
            <div class="step-number">03</div>
            <div class="step-title">Reclamación</div>
        </div>
        <div class="step" data-step="4">
            <div class="step-number">04</div>
            <div class="step-title">Detalles</div>
        </div>
        <div class="step" data-step="5">
            <div class="step-number">05</div>
            <div class="step-title">Documentos</div>
        </div>
        <div class="step" data-step="6">
            <div class="step-number">06</div>
            <div class="step-title">Revisión</div>
        </div>
        <div class="step" data-step="7">
            <div class="step-number">07</div>
            <div class="step-title">Confirmación</div>
        </div>
    </div>

    <div id="step1">@include('registration.forms.step1-information')</div>
    <div id="step2">@include('registration.forms.step2-information')</div>
    <div id="step3">@include('registration.forms.step3-information')</div>
    <div id="step4">@include('registration.forms.step4-information')</div>
    <div id="step5">@include('registration.forms.step5-information')</div>
    <div id="step6">@include('registration.forms.step6-information')</div>
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
        
        for (let i = 1; i <= totalSteps; i++) {
            const stepElement = document.getElementById(`step${i}`);
            if (stepElement) {
                stepElement.style.display = (i === currentStep) ? 'block' : 'none';
            }
        }
        
        document.getElementById('prevStep').style.display = currentStep === 1 ? 'none' : 'block';
        document.getElementById('nextStep').textContent = currentStep === totalSteps ? 'Finalizar' : 'Siguiente';
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function resetProgress() {
        currentStep = 1;
        updateProgress();
        scrollToTop();
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