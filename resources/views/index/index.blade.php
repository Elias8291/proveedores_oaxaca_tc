@extends('dashboard') <!-- Asumiendo que el layout anterior está en resources/views/layouts/app.blade.php -->

@section('title', 'Inicio - Dashboard Gobierno')

@section('content')
<div class="content">
    <div class="dashboard-welcome">
        <h1>Bienvenido al Dashboard</h1>
        <p>Hola, Nombre del Usuario. Aquí puedes gestionar tus actividades y revisar información importante.</p>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Usuarios Activos</h3>
                <p class="stat-number">150</p>
            </div>
            <div class="stat-card">
                <h3>Tareas Pendientes</h3>
                <p class="stat-number">12</p>
            </div>
            <div class="stat-card">
                <h3>Notificaciones</h3>
                <p class="stat-number">5</p>
            </div>
        </div>
        
        <div class="quick-actions">
            <h2>Acciones Rápidas</h2>
            <button class="action-btn">Crear Nueva Tarea</button>
            <button class="action-btn">Ver Reportes</button>
            <button class="action-btn">Configuración</button>
        </div>
        
        <!-- Sección de Cursos agregada basada en la imagen anterior -->
        <div class="courses-section">
            <h2>Cursos de Experiencia de Usuario</h2>
            
            <div class="courses-grid">
                <div class="course-card blue">
                    <div class="course-content">
                        <div class="icon-container blue-bg">
                            <span class="icon">✳</span>
                        </div>
                        <h3 class="course-title">Design Thinking</h3>
                        <p class="course-description">How to apply design thinking to your problems in order to generate innovative and user-centric solutions.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container teal-bg">
                            <span class="icon">⚛</span>
                        </div>
                        <h3 class="course-title">Human Computer Interactions</h3>
                        <p class="course-description">How to carry out the design process involved in interaction design, navigation design, and screen design.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container red-bg">
                            <span class="icon">🌐</span>
                        </div>
                        <h3 class="course-title">Interaction Design for Usability</h3>
                        <p class="course-description">An understanding of the basics of usability, including visual design, navigation and menu design.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container purple-bg">
                            <span class="icon">▲</span>
                        </div>
                        <h3 class="course-title">UI Design Patterns for Successful Software</h3>
                        <p class="course-description">How to ensure minimal effort is required from the user when moving through the user interface.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
            </div>
            
            <div class="courses-grid">
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container teal-bg">
                            <span class="icon">🚀</span>
                        </div>
                        <h3 class="course-title">The Practical Guide to Usability</h3>
                        <p class="course-description">Why usability matters, and what the key user interface design principles and usability considerations are.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container red-bg">
                            <span class="icon">❌</span>
                        </div>
                        <h3 class="course-title">Web Design: The Ultimate Guide</h3>
                        <p class="course-description">How to analyze existing product and web designs according to the Gestalt principles.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container purple-bg">
                            <span class="icon">⚙️</span>
                        </div>
                        <h3 class="course-title">How to Create a UX Portfolio</h3>
                        <p class="course-description">How to craft compelling UX case studies that tell a story and motivate recruiters to invite you for job interviews.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="course-content">
                        <div class="icon-container teal-bg">
                            <span class="icon">@</span>
                        </div>
                        <h3 class="course-title">Information Visualization</h3>
                        <p class="course-description">How the eye and the brain function together to deliver imagery, and how it affects information visualization design.</p>
                        <div class="arrow"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }
    
    body {
        background-color: #f9f9fb;
    }
    
    .dashboard-welcome {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .dashboard-welcome h1 {
        color: #2c3e50;
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .dashboard-welcome p {
        color: #7f8c8d;
        margin-bottom: 20px;
    }
    
    .stats-container {
        display: flex;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .stat-card {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        flex: 1;
        min-width: 200px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .stat-number {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
        margin: 10px 0 0;
    }
    
    .quick-actions {
        margin-top: 40px;
    }
    
    .quick-actions h2 {
        color: #2c3e50;
        margin-bottom: 15px;
    }
    
    .action-btn {
        background: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        margin-bottom: 10px;
        transition: background 0.3s;
    }
    
    .action-btn:hover {
        background: #2980b9;
    }
    
    /* Estilos para los cursos */
    .courses-section {
        margin-top: 40px;
    }
    
    .courses-section h2 {
        color: #4e57ca;
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 1024px) {
        .courses-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 640px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-container {
            flex-direction: column;
        }
    }
    
    .course-card {
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
    }
    
    .course-card.blue {
        background-color: #4e57ca;
        color: white;
    }
    
    .icon-container {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
    
    .blue-bg {
        background-color: #eef0ff;
    }
    
    .teal-bg {
        background-color: #e6f7f7;
    }
    
    .red-bg {
        background-color: #ffeeee;
    }
    
    .purple-bg {
        background-color: #f0eeff;
    }
    
    .icon {
        width: 24px;
        height: 24px;
        display: block;
    }
    
    .course-content {
        padding: 20px;
        flex-grow: 1;
    }
    
    .course-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }
    
    .blue .course-title {
        color: white;
    }
    
    .course-description {
        font-size: 14px;
        color: #666;
        line-height: 1.4;
    }
    
    .blue .course-description {
        color: rgba(255, 255, 255, 0.8);
    }
    
    .arrow {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 20px;
        height: 20px;
        background-color: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .blue .arrow {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .arrow::after {
        content: "→";
        font-size: 14px;
        color: #4e57ca;
    }
    
    .blue .arrow::after {
        color: white;
    }
</style>
@endsection