<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $response = response()->view('auth.login');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    }

    public function login(Request $request)
    {
        $request->validate([
            'rfc' => 'required|string|max:13',
            'password' => 'required|string|min:8',
        ]);
    
        $rfc = strtoupper(trim($request->rfc));
    
        $user = User::where('rfc', $rfc)->first();
    
        if (!$user) {
            return back()->withErrors([
                'rfc' => 'El RFC proporcionado no existe en nuestros registros.',
            ])->withInput($request->only('rfc', 'remember'));
        }
    
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ])->withInput($request->only('rfc', 'remember'));
        }
    
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();
        $user->update(['ultimo_acceso' => now()]);
        
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}