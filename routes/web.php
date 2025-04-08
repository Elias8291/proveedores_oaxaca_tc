<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectorController;


// Middleware para verificar si el usuario está autenticado
Route::middleware(['web'])->group(function () {
    // Ruta principal
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        $response = response()->view('welcome');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    });
    Route::get('/api/sectores', [SectorController::class, 'getSectores']);
    Route::get('/api/sectores/{sector}/actividades', [SectorController::class, 'getActividades']);

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        $response = response()->view('auth.login');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return redirect('/');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Ruta de dashboard protegida
    Route::get('/dashboard', function () {
        if (!Auth::check()) {
            return redirect('/');
        }
        $response = response()->view('index.index');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    })->name('dashboard')->middleware('auth');

    // Ruta de usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    // Ruta de inscripción
    Route::get('/registration', function () {
        if (!Auth::check()) {
            return redirect('/');
        }
        $response = response()->view('registration.index');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    })->name('registration.index')->middleware('auth');

    // Ruta para el formulario 1
    Route::post('/registration/formularios', function (Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }
        $request->validate([
            'terms' => 'accepted',
        ]);
        $response = response()->view('registration.forms.formularios');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    })->name('registration.form1')->middleware('auth');
    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
   
});