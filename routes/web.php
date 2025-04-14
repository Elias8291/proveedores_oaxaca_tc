<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí se definen las rutas web de la aplicación, organizadas por tipo:
| - Públicas: Accesibles sin autenticación.
| - Autenticadas: Requieren autenticación (middleware 'auth').
| - Formularios: Relacionadas con el registro y formularios.
| - APIs: Endpoints para datos dinámicos.
|
*/

// Middleware 'web' para todas las rutas
Route::middleware('web')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Rutas Públicas
    |--------------------------------------------------------------------------
    */
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return response()->view('welcome')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    })->name('home');

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return redirect('/');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Rutas Autenticadas
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return response()->view('index.index')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        })->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');

        /*
        |--------------------------------------------------------------------------
        | Rutas de Formularios y Registro
        |--------------------------------------------------------------------------
        */
        Route::get('/registration', [SolicitanteController::class, 'showRegistrationIndex'])->name('registration.index');

        // Ruta para el formulario principal
        Route::get('/registration/form1', [SolicitanteController::class, 'showForm1'])->name('registration.form1.view');
        Route::post('/registration/form1', [SolicitanteController::class, 'proceedToForm1'])->name('registration.form1.post');

        Route::get('/tramites', [SolicitanteController::class, 'showForm'])->name('tramites.form');

        /*
        |--------------------------------------------------------------------------
        | Rutas de Configuración de Cuenta
        |--------------------------------------------------------------------------
        */
        Route::post('/registro', [RegisterController::class, 'register'])->name('register');
        Route::get('/set-password', [SetPasswordController::class, 'showSetForm'])->name('password.set.form');
        Route::post('/set-password', [SetPasswordController::class, 'setPassword'])->name('password.set');
        Route::get('/registration/form1', [SectorController::class, 'showRegistrationForm'])
            ->name('registration.form1.view');

        Route::get('/sectores', [SectorController::class, 'getSectores'])
            ->name('sectores.index');

        Route::get('sectores/{sector}/actividades', [SectorController::class, 'getActividadesPorSector']);

        Route::get('/solicitante/direccion-data', [SolicitanteController::class, 'getDireccionData'])->middleware('auth');
        Route::get('/registro', [App\Http\Controllers\EstadoController::class, 'index'])->name('registro.form');
        Route::get('/estados', [EstadoController::class, 'getEstadosForForm'])->name('estados.get');
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas API
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {
        Route::get('/solicitante/data', [SolicitanteController::class, 'getSolicitanteData'])->name('solicitante.data');
        Route::get('/api/solicitante-data', [SolicitanteController::class, 'getSolicitanteData'])->name('api.solicitante.data');
    });

    Route::middleware('auth:api')->get('/solicitante', [SolicitanteController::class, 'getSolicitante'])->name('api.solicitante');
});
