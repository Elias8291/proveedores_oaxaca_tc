<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Add this import

class SetPasswordController extends Controller
{
    public function showSetForm(Request $request)
    {
        return view('auth.set-password', ['token' => $request->token]);
    }

    public function setPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('verification_token', $request->token)->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Token inválido o expirado.');
        }

        $user->password = Hash::make($request->password);
        $user->verification_token = null;
        $user->email_verified_at = now();
        $user->save();

        // Use Auth::login() instead of auth()->login()
        Auth::login($user);

        return redirect('/home')->with('success', 'Contraseña establecida correctamente. ¡Bienvenido!');
    }
}