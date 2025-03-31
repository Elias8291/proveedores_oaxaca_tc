<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

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

    // Ruta de login
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
    
});
