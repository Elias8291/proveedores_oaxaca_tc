<!-- resources/views/registration/index.blade.php -->
@extends('dashboard')

@section('title', 'Inscripción al Padrón de Proveedores - Proveedores de Oaxaca')
<link rel="stylesheet" href="{{ asset('assets/css/formularios.css') }}">
@section('content')
<div class="dashboard-container">
    <!-- Progress bar - moves with page scroll -->
    <div class="progress-container">
        <div class="progress-steps">
            <div class="step step-completed">
                <div class="step-icon">✓</div>
                <span class="step-text">About</span>
            </div>
            <div class="step step-completed">
                <div class="step-icon">✓</div>
                <span class="step-text">Details</span>
            </div>
            <div class="step step-completed">
                <div class="step-icon">✓</div>
                <span class="step-text">Application form</span>
            </div>
            <div class="step step-current">
                <div class="step-icon">4</div>
                <span class="step-text">Hiring stages</span>
            </div>
            <div class="step step-pending">
                <div class="step-icon">5</div>
                <span class="step-text">Job portals</span>
            </div>
        </div>
    </div>

    <!-- Form container with independent scrolling -->
    <div class="form-container">
        <!-- Left sidebar - independently scrollable -->
        <div class="form-sidebar">
            <ul class="sidebar-nav">
                <li class="active">
                    <span class="sidebar-icon">📋</span>Applied
                </li>
                <li class="dropdown">
                    <div>
                        <span class="sidebar-icon">❓</span>Questionnaire
                    </div>
                    <span class="dropdown-arrow">▼</span>
                </li>
                <li class="dropdown">
                    <div>
                        <span class="sidebar-icon">🗣️</span>Interview
                    </div>
                    <span class="dropdown-arrow">▼</span>
                </li>
                <li class="dropdown">
                    <div>
                        <span class="sidebar-icon">📝</span>Review
                    </div>
                    <span class="dropdown-arrow">▼</span>
                </li>
                <li>
                    <span class="sidebar-icon">✅</span>Hiring complete
                </li>
            </ul>
            <div style="margin-top: 20px;">
                <button class="add-button">
                    <span class="add-icon">+</span> New stage
                    <span class="dropdown-arrow">▼</span>
                </button>
            </div>
        </div>

        <!-- Main content area - independently scrollable -->
        <div class="form-content">
            <div class="form-section">
                <div class="section-title">Stage name</div>
                <div class="form-field">
                    <input type="text" value="Applied" placeholder="Stage name">
                </div>
            </div>

            <div class="form-section">
                <div class="automation-container">
                    <div class="section-title">Automation</div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="note">
                    Move candidate to next stage once it was added to your list of Candidates.
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">Default form fields</div>
                <div class="input-with-icon">
                    <span class="input-icon">👤</span>
                    Name fields
                </div>
                <div class="input-with-icon">
                    <span class="input-icon">✉️</span>
                    Email
                </div>
                <div class="input-with-icon">
                    <span class="input-icon">📞</span>
                    Number
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">Optional form fields</div>
                <div class="note">
                    We encourage you to keep your default application form short to increase the completion rate.
                </div>
                <button class="add-button">
                    <span class="add-icon">+</span> Add new field
                    <span class="dropdown-arrow">▼</span>
                </button>
            </div>

            <div class="navigation-buttons">
                <button class="button">Back: Application form</button>
                <button class="button button-primary">Next: Job portals</button>
            </div>
            
            <!-- Extra content to ensure scrolling is possible -->
            <div style="height: 200px;"></div>
        </div>
    </div>
</div>
@endsection