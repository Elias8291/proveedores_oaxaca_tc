<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la página de perfiles
        return view('profiles.index'); // Ejemplo: retorna una vista
    }
}