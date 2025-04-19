<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SetPasswordController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SolicitanteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstadoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Organized web routes for the application, grouped by:
| - Public: Accessible without authentication.
| - Authenticated: Require authentication (middleware 'auth').
| - API: Endpoints for dynamic data.
|
*/

Route::middleware('web')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', function () {
        return Auth::check()
            ? redirect()->route('dashboard')
            : response()->view('welcome')->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
            ]);
    })->name('home');

    Route::get('/login', function () {
        return Auth::check() ? redirect()->route('dashboard') : redirect('/');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Public Registration Route
    Route::post('/register', [SolicitanteController::class, 'register'])->name('register');

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return response()->view('index.index')->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
            ]);
        })->name('dashboard');

        // Admin Resources
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');

        // Registration and Form Routes
        Route::get('/registration', [SolicitanteController::class, 'showRegistrationIndex'])->name('registration.index');
        Route::get('/registration/form1', [SolicitanteController::class, 'showForm1'])->name('registration.form1');
        Route::post('/registration/form1', [SolicitanteController::class, 'proceedToForm1'])->name('registration.form1.post');
        Route::get('/registration/formularios/formularios', [SectorController::class, 'showRegistrationForm'])
            ->name('registration.formularios.formularios');
        Route::get('/tramites', [SolicitanteController::class, 'showForm'])->name('tramites.form');

        // Account Configuration
        Route::post('/registro', [RegisterController::class, 'register'])->name('registro'); // Renamed to avoid conflict
        Route::get('/set-password', [SetPasswordController::class, 'showSetForm'])->name('password.set.form');
        Route::post('/set-password', [SetPasswordController::class, 'setPassword'])->name('password.set');

        // Data Endpoints
        Route::get('/sectores', [SectorController::class, 'getSectores'])->name('sectores.index');
        Route::get('/sectores/{sector}/actividades', [SectorController::class, 'getActividadesPorSector'])->name('sectores.actividades');
        Route::get('/estados', [EstadoController::class, 'getEstadosForForm'])->name('estados.get');
        Route::get('/solicitante/direccion-data', [SolicitanteController::class, 'getDireccionData'])->name('solicitante.direccion-data');
        Route::get('/solicitantes/index', fn () => view('solicitantes.index'))->name('solicitantes.index');
        Route::post('/registration/accept-terms', [SolicitanteController::class, 'acceptTerms'])->name('registration.accept-terms');

        // Legacy Registro Route
        Route::get('/registro', [EstadoController::class, 'index'])->name('registro.form');
    });

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/solicitante/data', [SolicitanteController::class, 'getSolicitanteData'])->name('solicitante.data');
        Route::get('/api/solicitante-data', [SolicitanteController::class, 'getSolicitanteData'])->name('api.solicitante.data');
    });

    Route::middleware('auth:api')->get('/solicitante', [SolicitanteController::class, 'getSolicitante'])->name('api.solicitante');
});