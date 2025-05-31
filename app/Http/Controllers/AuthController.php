<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = [
            $fieldType => $request->email,
            'password' => $request->password,
            'estado' => 'activo',
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $this->redirectByRole($user);
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas o usuario inactivo'])->withInput();
    }

    public function logout(Request $request)
    {
        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', '¡Hasta pronto!');
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // Mostrar formulario de registro
    public function register()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function handleRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente',
            'estado' => 'activo',
        ]);

        Auth::login($user);
        return $this->redirectByRole($user);
    }

    // Redirigir según el rol
    protected function redirectByRole($user)
    {
        switch ($user->rol) {
            case 'admin':
                return redirect()->route('admin.index');
            case 'cocinero':
                return redirect()->route('cocinero.index');
            case 'cajero':
                return redirect()->route('cajero.index');
            case 'cliente':
            default:
                return redirect()->route('cliente.index');
        }
    }

    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }
} 