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
    $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
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