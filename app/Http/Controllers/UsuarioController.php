<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('admin.usuarios');
    }

    public function apiList()
    {
        $usuarios = User::select('id', 'name as usuario', 'rol')->get();
        return response()->json($usuarios);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'usuario' => 'required|string|min:4|unique:users,name',
            'password' => 'required|string|min:8',
            'rol' => 'required|string',
        ]);
        $user = User::create([
            'name' => $data['usuario'],
            'password' => Hash::make($data['password']),
            'rol' => $data['rol'],
        ]);
        return response()->json(['success' => true, 'message' => 'Usuario registrado correctamente']);
    }

    public function apiUpdate(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:users,id',
            'usuario' => 'required|string|min:4',
            'rol' => 'required|string',
        ]);
        $user = User::findOrFail($data['id']);
        $user->name = $data['usuario'];
        $user->rol = $data['rol'];
        $user->save();
        return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    }

    public function apiDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function apiGet($id)
    {
        $user = User::select('id', 'name as usuario', 'rol')->findOrFail($id);
        return response()->json($user);
    }
} 