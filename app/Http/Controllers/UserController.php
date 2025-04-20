<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all users with their roles
        $users = User::with('roles')->get();
        
        // Fetch all roles for the create user modal
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rfc' => 'required|string|max:13',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'rfc' => $validated['rfc'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'status' => $validated['status'],
        ]);

        // Assign the selected role
        $user->assignRole($validated['role']);

        return response()->json(['message' => 'Usuario creado exitosamente'], 201);
    }
}