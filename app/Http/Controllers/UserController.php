<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importa el modelo User

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Obtiene todos los usuarios de la base de datos
        return view('users.index', compact('users')); // Envía los datos a la vista
    }
}
